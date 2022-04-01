<?php
namespace Controllers;

use Entity\Movie;
use Entity\Genre;
use Entity\PopularityHistory;

class MovieController extends Controller

{
  //=============================================================================================
  static function sortPopularity ($a,$b){
    if ($a->getPopularity()==$b->getPopularity()) {
      return 0;
    }
    return ($a->getPopularity() > $b->getPopularity()) ? -1 : 1;
    
  }
  
   static function date_outil ($date,$nombre_jour){
  
    $year = substr($date, 0, -6);   
    $month = substr($date, -5, -3);   
    $day = substr($date, -2);   
 
    // récupère la date du jour
    $date_string = mktime(0,0,0,$month,$day,$year);
 
    // Supprime les jours
    $timestamp = $date_string - ($nombre_jour * 86400);
    $nouvelle_date = date("Y-m-d", $timestamp); 
 
    // pour afficher
   return $nouvelle_date;
 
  }
  //=================================================================================================
  public function getMovieGenres ($params)
  {
    
  
  
    $em=$params["em"];
    
    //récupère l'id de l'émotion correspondant
    $emotionId = $_POST["emotion"];
    
    
    //recherche l'émotion dans la table émotion pour avoir le genre qui lui est relié avec getGenre()
    $genreRepository = $em->getRepository('Entity\Emotion');
    $emotionGenre = $genreRepository->find($emotionId);
    if(!$emotionGenre)
    {
      echo "erreur";
    }
    
    //var_dump($emotionGenre->getGenres());
    $genres = $emotionGenre->getGenres();
    
    //tableau qui va récupérer les films des genres correspondants
    $movies=[];
    foreach ($genres as $genre){
      //var_dump("===============".$genre->getName()."===============");
      foreach ($genre->getMovies() as $movie){
        //var_dump($movie->getTitle());
        $movies[]=$movie;
      };
    }
    
    
    $dateToday = date("Y-m-d");
    $dateModify = $this->date_outil($dateToday,90); //Enlève 90 jours de la date d'aujourd'hui
    //var_dump($dateModify);
    
    $moviesRecent= []; //tableau de films récent
    foreach($movies as $movie ){
      if($movie->getReleaseDate() <= $dateToday && $movie->getReleaseDate() >= $dateModify ){
        //var_dump($movie->getTitle()."======".$movie->getReleaseDate());
        $moviesRecent[]=$movie; //met le film dans le tableau
      }
    }
    
    
    //va trier le tableau par ordre de popularité décroissant
    uasort($movies,array($this,'sortPopularity'));  //appelle la fonction sortPopularity()  
    /*
    foreach($movies as $movie) {
      echo $movie->getTitle()."======".$movie->getId()."======".$movie->getPopularity()."<br/>";
    }
    */
    
    $moviesFr= []; //tableau de film français
    foreach($movies as $movie ){
      if($movie->getOriginalLanguage() == "fr"){
       $moviesFr[]=$movie;
      }
    }
    
    
     
     echo $this->twig->render('movieListe.twig',['movies' =>$movies, 'moviesFr' =>$moviesFr, 'moviesRecent' => $moviesRecent, 'emotionId' => $emotionId]);
  }
  

  public function movieDetail ($params)
  {
    $em=$params["em"];
     
    //var_dump($_SERVER['HTTP_REFERER']); die;
    $returnURL = $_SERVER['HTTP_REFERER'];
    $movieId = $_POST["movieId"];
    //var_dump($movieId);
  
    $emotionId = $_POST["emotionId"];
    
    $movieRepository = $em->getRepository('Entity\Movie');
    $movie = $movieRepository->find($movieId);
    if(!$movie)
    {
      echo "erreur !";
    }
    
    // RECUPERE LES GENRES DU FILM
    $genres = ($movie->getGenres());
    //var_dump($genres);
    $nameGenre = [];
    foreach ($genres as $genre)
    {
      //var_dump($value->getName());
       $nameGenre[]= $genre->getName();
    }
    
    //var_dump($nameGenre);
    // TRANSFORME LE TABLEAU EN STRING
    $movieGenres = implode(", ", $nameGenre);
    //var_dump($movieGenres);
    
    /*  HISTORIQUE POPULARITE */
    $dql = "select p from Entity\PopularityHistory p where p.movie='$movieId'";
    //SELECT * FROM `popularity_history` WHERE `movie_id`=1;
    $query = $em->createQuery($dql);
    $popularities=$query->getResult();
    $arrayHistory = [];
    foreach ($popularities as $value)
    {
      //var_dump($value->getPopularity());
      $dates = $value->getDate();
      //var_dump($dates);
      
    
      
      foreach ($dates as $key => $date)
      {
        	if ($key == "date")
        	{
        	  //var_dump($date);
        	  $dateConvert= date_create($date); // converti le string en format date pour le date_format
        	  $dateFormat =date_format($dateConvert,"Y/m/d"); // enlève les 00:00:00.000000 après la date
        	  $dateChange = str_replace("-",",",$dateFormat); //modifier les - pour des ,
        	  $arrayHistory[] = [
               $dateChange=> $value->getPopularity(),
            ];
        	}
      }
    }
    //var_dump($arrayHistory);
    
    
   /*  FIN HISTORIQUE POPULARITE */
    
    /* TRAILER MOVIE  */
    $moviedbId = $movie->getMoviedbId();
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'. $moviedbId.'/videos?api_key=6efd8c2be252b7db9eb325cd0e495624&language=fr-fr',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //var_dump($response);
    
    $jsondecode = json_decode($response);
    $arrayResults = $jsondecode->results;  //recupere les tableaux de results
    //var_dump($arrayResults);
    
    
    if (empty($arrayResults)) {  //Si il n'y a pas de bande-annonce (empty = si variable et null)
      $keyTrailer = 'no trailer';
    }
    else{
    
    $i = 0;
    foreach($arrayResults as $value){
      if ($value->type == "Trailer" && $i < 1 ){   // avoir un seul trailer
        $keyTrailer = $value->key;
        $i++;
      }
    }
    
    }
    
    //var_dump($keyTrailer);
    
    /* CASTING FILM */
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'. $moviedbId.'/credits?api_key=6efd8c2be252b7db9eb325cd0e495624&language=fr-fr%0A',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    //echo $response;
    
    $jsondecode = json_decode($response);
    //var_dump($jsondecode);
    
    $cast = $jsondecode->cast; //tous les acteurs;
    
    $crew = $jsondecode->crew; //tous le reste de l'équipe du film;
    
    //récupérer juste le Réalisateur :
    foreach ( $crew as $value){
     if($value->job == "Director") {
       $director = $value->name;
     }
    }
    
    /* MOVIE AVAILABILITY   */
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'. $moviedbId.'/watch/providers?api_key=6efd8c2be252b7db9eb325cd0e495624',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    
    curl_close($curl);
    $jsondecode = json_decode($response);
    //var_dump($jsondecode);
    $arrayAvailability = [];
    foreach( $jsondecode->results  as $contry => $availability ){
      if($contry == "FR"){
        foreach($availability as $value){
        
          //var_dump($value);
          $arrayAvailability[]= $value;
        }
      
        
      }
      
    }
    //var_dump($arrayAvailability);
    //die;
    
     echo $this->twig->render('movie.twig',['movie' =>$movie, 'movieGenres' =>$movieGenres, 'arrayHistory'=>$arrayHistory, 'keyTrailer' =>$keyTrailer, 'cast' =>$cast, 
      "director"=>$director,  'returnURL'=>$returnURL, 'emotionId' =>$emotionId, 'arrayAvailability' =>$arrayAvailability]);
    
  }

}

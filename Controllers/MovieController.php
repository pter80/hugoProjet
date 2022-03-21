<?php
namespace Controllers;

use Entity\Movie;
use Entity\Genre;
use Entity\PopularityHistory;

class MovieController extends Controller

{
  //donner tous les genres de la table genre
  public function movieGenre($params)
  {
    $em=$params["em"];
    $dql = "select g from Entity\Genre g";
    $query = $em->createQuery($dql);
    $genres=$query->getArrayResult();
    //var_dump(json_encode($genres,JSON_HEX_QUOT));die;
    
    //echo $this->twig->render('genreBis.twig',['genres' => json_encode($genres)]);
    echo $this->twig->render('genre.twig',['genres' => $genres]);
    
    
    
  }
  public function readAll ($params){
    $em=$params["em"];
    $dql = "select g from Entity\Genre g";
    $query = $em->createQuery($dql);
    $genres=$query->getArrayResult();
    //echo(json_encode($genres));die;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['genres'=>$genres]); 
    // json_decode = Récupère une chaîne encodée JSON et la convertit en une variable PHP.
  }
  public function listeGenre ($params)
  {
    $genreId = $_POST["emotionGenre"];
    var_dump($genreId);
    die;
    
    $em=$params["em"];
    $genreRepository = $em->getRepository('Entity\Genre');
    $genre = $genreRepository->find($genreId);
    if(!$genre)
    {
      echo "erreur";
    }
    //var_dump($genre->getName());
    
    $movies=$genre->getMovies();
    /*
    foreach ($movies as $movie){
      var_dump($movie->getTitle());
      break;
      
    }
    */
    
    echo $this->twig->render('movieListe.twig',['movies' =>$movies]);
    
  }
  
  public function movieDetail ($params)
  {
    $movieId = $_POST["movieId"];
    //var_dump($movieId);
    
    $em=$params["em"];
    $movieRepository = $em->getRepository('Entity\Movie');
    $movie = $movieRepository->find($movieId);
    if(!$movie)
    {
      echo "erreur !";
    }
    
    // RECUPERE LES GENRES DU FILM
    $genres = ($movie->getGenres());
    $nameGenre = [];
    foreach ($genres as $value)
    {
      //var_dump($value->getName());
      array_push($nameGenre, $value->getName());
    }
    
    //var_dump($nameGenre);
    // TRANSFORME LE TABLEAU EN STRING
    $movieGenres = implode(", ", $nameGenre);
    //var_dump($movieGenres);
    
    // HISTORIQUE POPULARITE
    $dql = "select p from Entity\PopularityHistory p where p.movie='$movieId'";
    //SELECT * FROM `popularity_history` WHERE `movie_id`=1;
    $query = $em->createQuery($dql);
    $popularities=$query->getResult();
    $arrayPop = [];
    $arrayDate = [];
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
        	  array_push($arrayDate, $date);
        	  
        	}
        	
        	
      }
    
      array_push($arrayPop, $value->getPopularity());
    }
    
    //var_dump($arrayPop);
    //var_dump($arrayDate);
    
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
    else {
       /* Parcourir le 1er tableau  */
      foreach ($arrayResults[0] as $key => $value) {
        if ($key == "key"){
          $keyTrailer = $value;
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
  
    
     echo $this->twig->render('movie.twig',['movie' =>$movie, 'movieGenres' =>$movieGenres, 'arrayPop'=>$arrayPop, 'arrayDate'=>$arrayDate, 'keyTrailer' =>$keyTrailer, 'cast' =>$cast, "director"=>$director]);
    
  }

}

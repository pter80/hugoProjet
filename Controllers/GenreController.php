<?php
namespace Controllers;

use Entity\Genre;

class GenreController extends Controller

{
  
  public function liste($params)
  {
     
    //$pr = new Product();
    //var_dump($pr);die;
    $em = $params['em'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/genre/movie/list?api_key=6efd8c2be252b7db9eb325cd0e495624&language=fr',
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
    //var_dump ($jsondecode);
    
    foreach ($jsondecode->genres as $key => $value) {
        $qb=$em->createQueryBuilder();
        $qb->select('g')
          ->from('Entity\Genre', 'g')
          ->where('g.moviedb_id = :moviedbId')
          ->setParameter('moviedbId', $value->id)
          ->setMaxResults(1)
          ;
        
        $query = $qb->getQuery();
        //var_dump($query->getSql());
        $genre = $query->getOneOrNullResult();
        var_dump ($value->name);
        if(!$genre){
          //crée le genre
          $genre = new Genre;
        }
        else{
          var_dump("le genre existe déja !");
          continue;
        }
        var_dump("le genre n'existe pas !");
        $genre->setName($value->name);
        $genre->setMoviedbId($value->id);
        $em->persist($genre);
        $em->flush();
        
        echo "<br/>";
    }
    
    //var_dump ($jsonEncode->genres[1]);
    //echo $response;
    //die();
    
  }
  



}

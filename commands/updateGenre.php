<?php


//bootstrap.php

require_once "../vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
//Déclaration de la classe Genre 
use Entity\Genre;

$paths = array("src/Entity","toto");
$isDevMode = true;
$proxyDir=null;
$cache=null;
// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'hugo',
    'password' => 'bts2020',
    'dbname'   => 'hugo',
);
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."src/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
//$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);

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
          var_dump("la genre existe deja !");
          continue;
        }
        var_dump("Genre enregistre !");
        $genre->setName($value->name);
        $genre->setMoviedbId($value->id);
        $em->persist($genre);
        $em->flush();
        
        echo "<br/>";
    }
    
    //var_dump ($jsonEncode->genres[1]);
    //echo $response;
    //die();
    
  

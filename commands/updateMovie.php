<?php


//bootstrap.php

require_once "../vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
//Déclaration de la classe Movie
use Entity\Movie;
use Entity\PopularityHistory;

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

//requete API
$curl = curl_init();



for ($i=1; $i <= 500; $i++)
{
    
    curl_setopt_array($curl, array(
    
        CURLOPT_URL => 'https://api.themoviedb.org/3/discover/movie?api_key=6efd8c2be252b7db9eb325cd0e495624&language=fr&sort_by=popularity.desc&include_adult=false&include_video=false&page='.$i,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    
    ));
    
    $response = curl_exec($curl);
    //var_dump ($response);
    
    $jsondecode = json_decode($response);
    //var_dump($jsondecode->results);
    
foreach ($jsondecode->results as $key => $value) {
    var_dump ("le film : ",$value->title);
    $qb=$em->createQueryBuilder();
    $qb->select('m')
      ->from('Entity\Movie', 'm')
      ->where('m.moviedb_id = :moviedbId')
      ->setParameter('moviedbId', $value->id)
      ->setMaxResults(1)
      ;
    $query = $qb->getQuery();
    //var_dump($query->getSql());
    $movie = $query->getOneOrNullResult();
    
    //vérifier si le film existe dans la table Movie
    if(!$movie){
      //crée le movie
      var_dump("creation du film");
	$movie = new Movie;
	
      
    }
    $movie->setTitle($value->title);
    $movie->setMoviedbId($value->id);
    $movie->setTitle($value->title);
    $movie->setMoviedbId($value->id);
    $movie->setReleaseDate($value->release_date);
    $movie->setOriginalTitle($value->original_title);
    $movie->setOriginalLanguage($value->original_language);
    $movie->setOverview($value->overview);
    $movie->setPopularity($value->popularity);
    $movie->setPosterPath($value->poster_path);
    $movie->setVoteAverage($value->vote_average);
    $movie->setGenreIds($value->genre_ids);
    
    $em->persist($movie);
	$em->flush();
    
    $dt=date("d/m/Y");
    $now = date_create(); 
    //var_dump($now);

    
    //mettre a jour l'historique de popularite
    $qb=$em->createQueryBuilder();
    $qb->select('p')
      ->from('Entity\PopularityHistory', 'p')
      ->where('p.movie =:movie')
      ->andWhere('p.date=:now')
      ->setParameters(['movie'=>$movie,'now'=>$now->format('Y-m-d')])
      ->setMaxResults(1)
      ;
    $query = $qb->getQuery();
    //var_dump($query->getSql());
    $popularityHistory = $query->getOneOrNullResult();

    //vérifier si l'historique de popularité et enregistré dans la table PopularityHistory
    if(!$popularityHistory) {
        
        var_dump("Popularité enregistre");
        $popularityHistory = new PopularityHistory;
        $popularityHistory->setMovie($movie);
        $popularityHistory->setDate($now);
        
    }
    $popularityHistory->setPopularity($movie->getPopularity());
    
    $em->persist($popularityHistory);
    
    
    echo "<br/>";
    $em->flush();
}


}  


//var_dump ($jsonEncode->genres[1]);
//echo $response;


curl_close($curl);

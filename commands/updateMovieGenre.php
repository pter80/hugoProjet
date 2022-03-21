
<?php


//bootstrap.php

require_once "../vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;



//use Controllers\IndexController;
//session_start();
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
//var_dump($params);die;
$dql="SELECT m FROM Entity\Movie m";
$qb=$query = $em->createQuery($dql);
$movies=$qb->getResult();

//$i = 0;


foreach ($movies as $movie){
    //$i++;
    $condition ="enregistrement des genres du film";
   //var_dump("le film :",$result->getTitle(), " genre : ", $result->getGenreIds());
   
    //var_dump("le film :",$movie->getTitle());
    foreach ($movie->getGenreIds() as $genreId)
    {
        //var_dump("le film :",$movie->getTitle(), "genre : ",$genreId);
       
        //var_dump($genreId);       
        $qb=$em->createQueryBuilder();
        $qb->select('g')
           ->from('Entity\Genre','g')
           ->where('g.moviedb_id = :moviedbId')
           ->setParameter('moviedbId', $genreId)
           ->setMaxResults(1)
           ;
        $query = $qb->getQuery();
        //var_dump($query->getSql());
        $genre = $query->getOneOrNullResult();   
        //var_dump($genre->getId());
        
        
        //compare table genre du film et le genre dans genre_film
        //var_dump ($movie->getMyGenreIds(),$movie->getGenreIds());
        $result = array_diff($movie->getGenreIds(),$movie->getMyGenreIds());
        
        
        //verifier que le genre n'est pas deja dans movie_genre
        if($result != null){
            //var_dump("enregistrement des genres du film");
            
            //verifie si le genre_id existe
            if($genre){
                $movie->addGenre($genre);
                $em->persist($movie);
                $em->flush();
            }
            else{
                var_dump("le genre n'existe pas !");
            }
        }
        else {
            $condition = "les genres sont déja enregistrer !";
        }
       
       
        
    }
    
    /*
    if ($i > 20) {
        break;
    }
    */
    
    var_dump($condition);
    
    
}

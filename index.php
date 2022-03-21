<?php


//bootstrap.php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;



//use Controllers\IndexController;
session_start();

$class = "Controllers\\" . (isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'IndexController');
$target = isset($_GET['t']) ? $_GET['t'] : "index";
$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;


$params = array(
    "get"  => $getParams,
    "post" => $postParams,
    "path"=> "http://195.154.118.169/myFrameWork/"
);

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
$entityManager = EntityManager::create($dbParams, $config);
//var_dump($params);die;
$params["em"]=$entityManager;
/*

if (class_exists($class, true)) {
    
    $class = new $class();
    if (in_array($target, get_class_methods($class))) {
        call_user_func_array([$class, $target], $params);
    }
    else {
        call_user_func([$class, "index"]);
    }
} 
*/

if ($class == "Controllers\IndexController" && in_array($target, get_class_methods($class))) // si c = index et qu'on a un t = methode existante de c
{ 
    $class = new Controllers\IndexController; // c = index
    call_user_func_array([$class, $target], $params); // c = index et t = la methode existante
} else 
{ // dans tout les autres cas ou c != index et t n'existe pas alors
    $class = new $class; // c = index 
    call_user_func_array([$class, $target], array("params"=>$params)); 
}
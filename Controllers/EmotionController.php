<?php
namespace Controllers;

use Entity\Emotion;

class EmotionController extends Controller

{
  
  public function liste($params)
  {
    
    $em=$params["em"];
    $dql = "SELECT e,g FROM Entity\Emotion e LEFT JOIN e.genres g";
    $query = $em->createQuery($dql);
    $emotions=$query->getArrayResult();
    
    //var_dump($emotions);
    foreach($emotions as $value){
      //echo ("-----------------------------<br/>");
      //var_dump($value['name'],$value["emoji"]);
      $name = $value['name'];
      $emoji = $value["emoji"];

      foreach($value["genres"] as $i){
        //var_dump($i["id"]);
        $idGenre = $i["id"]; 
      }
      
    }
    
   echo $this->twig->render('genre.twig',['emotions' => $emotions]); 
    
    
   
  
  }

}
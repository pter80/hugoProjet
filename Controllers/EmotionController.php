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
    $emotionsArray = [];
    foreach($emotions as $value){
      echo ("-----------------------------<br/>");
      //var_dump($value['name'],$value["emoji"]);
      $name = $value['name'];
      $emoji = $value["emoji"];

      foreach($value["genres"] as $i){
        //var_dump($i["id"]);
        $idGenre = $i["id"]; 
      }
      
      array_push($emotionsArray, $name=>$emoji);
    }
    
    var_dump($emotionsArray);
    
    
   
  
  }

}
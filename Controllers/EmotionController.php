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
    $result = [];
    //var_dump($emotions);
    foreach($emotions as $value){
      $name = $value['name'];
      $emoji = $value["emoji"];
      $idGenres=[];
      foreach($value["genres"] as $i){
        //var_dump($i["id"]);
        $idGenres[] = $i["id"]; 
      }
      $result[] = [
        'nom'=>$name,
        'emoji'=>$emoji,
        'idGenres'=>$idGenres
      ];
     
      
    }
    
    //var_dump($result);die;
    
   echo $this->twig->render('genre.twig',['result' => json_encode($result)]); 
    
    
   
  
  }

}
<?php
namespace Controllers;

use Entity\Emotion;

class EmotionController extends Controller

{
  
  public function liste($params)
  {
    
    $em=$params["em"];
    $dql = "select e from Entity\Emotion e";
    $query = $em->createQuery($dql);
    $emotions=$query->getArrayResult();
    //var_dump($emotions);die;
    
    
   echo $this->twig->render('emotionListe.twig',['emotions' => $emotions]);
    
    
   
  
  }

}
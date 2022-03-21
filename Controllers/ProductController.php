<?php
namespace Controllers;

use Entity\Product;

class ProductController extends Controller

{
  
  public function liste($params)
  {
     
     //$pr = new Product();
     //var_dump($pr);die;
     $em=$params["em"];
     
     
     $dql = "select p from Entity\Product p";
     $query = $em->createQuery($dql);
     $result=$query->getResult();
     //var_dump($result);
     $products = $result;
     echo $this->twig->render('product_liste.twig',['products' =>$products]);
     
     
     $qb=$em->createQueryBuilder();
     $qb->select('p')
        ->from('Entity\Product', 'p');
     $query = $qb->getQuery();
     //var_dump($query->getSql());
     $products = $query->getResult();    
     
     //echo $this->twig->render('product_liste.twig', ['products'=>$products]);
    
  }
  
  public function edit($params) {
	  $em=$params["em"];
  	$idToFind=$params['get']['id'];      
	  $product=$em->find("Entity\Product",$idToFind);
	  //var_dump($product);
	  echo $this->twig->render('product_edit.twig', ['product'=>$product]);

  }
  
  public function update($params) {
    $idName = $_GET["id"];  //récupère l'id dans URL
    $nameToChange = $_POST["nameToChange"];
    //var_dump ($nameToChange);
    //var_dump($idName);
    $em=$params["em"];
	  $idToFind=$params['get']['id'];      
	  $product=$em->find("Entity\Product",$idToFind);
	  //var_dump($product);
	  $product->setName($nameToChange);
	  $em->persist($product);
	  $em->flush();
	  
	  
	  $this->liste($params);

	
    
  }


}

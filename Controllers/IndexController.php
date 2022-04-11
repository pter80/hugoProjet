<?php

namespace Controllers;

class IndexController extends Controller
{
    public function index()
    {
        //savoir si un utilisateur existe deja
        $connectUser = false;
        if (isset($_SESSION['username'])) {
            //La variable username est déjà enregistrée !';
            $connectUser = true;
        } 
        echo $this->twig->render('index.html', ['connectUser' =>$connectUser]);
    }
    
    
}
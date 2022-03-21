<?php

namespace Controllers;

class IndexController extends Controller
{
    public function index()
    {
        
        $users=[
            "user1","user2","user3","user4"
        ];
        
        $fruits=[
            "pomme", "poire", "abricot", "raisin", "pêche", "orange"
        ];
        
        
        
        
        echo $this->twig->render('index.html', ['name' => 'Hugo', 'fruits' =>$fruits, 'users' =>$users]);
    }
    
    
}
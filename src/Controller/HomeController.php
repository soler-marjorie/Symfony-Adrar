<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController{
    
    function hello(): Response{
        return new Response ('Hello, bienvenue sur symfony !');
    }

    
    #[Route(path:"/hello/{nom}", name:"app_home_hello")]
    public function helloTo($nom):Response {
        return new Response('Bonjour ' . $nom);
    }
}
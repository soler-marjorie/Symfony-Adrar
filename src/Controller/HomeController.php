<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController{
    
    // function hello(): Response{
    //     return new Response ('Hello, bienvenue sur symfony !');
    // }

    
    // #[Route(path:"/hello/{nom}", name:"app_home_hello")]
    // public function helloTo($nom):Response {
    //     return new Response('Bonjour ' . $nom);
    // }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
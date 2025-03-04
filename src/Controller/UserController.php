<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/logIn', name: 'app_user')]
    public function logIn(): Response{
        return $this->render('user/logIn.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}

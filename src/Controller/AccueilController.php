<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
class AccueilController{

    #[Route(path:"/addition/{nbr1}/{nbr2}", name:"app_accueil_addition")]
    function addition($nbr1, $nbr2): Response{
        if($nbr1 < 0 || $nbr2 < 0){
            return new Response('<p>Les nombres sont négatifs</p>');
        }
        
        $total = $nbr1 + $nbr2;
        return new Response ('<p>L’addition de' . $nbr1 . 'et' . $nbr2 . 'est égale au résultat : '. $total . '</p>');
    }

}
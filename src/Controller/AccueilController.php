<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
class AccueilController{

    #[Route(path:"/addition/{nbr1}/{nbr2}", name:"app_accueil_addition")]
    function addition(int $nbr1, int $nbr2): Response{
        if($nbr1 < 0 || $nbr2 < 0){
            return new Response('<p>Les nombres sont négatifs</p>');
        }
        
        $total = $nbr1 + $nbr2;
        return new Response ('<p>L’addition de ' . $nbr1 . ' et ' . $nbr2 . ' est égale au résultat : '. $total . '</p>');
    }
    //autre méthode addition
    /* class AccueilController
        {
            #[Route(path: '/addition/{nbr1}/{nbr2}',name:'app_accueil_addition')]
            public function addition(mixed $nbr1, mixed $nbr2): Response
            {
                $response = '<p>L’addition de ' . 
                    $nbr1 . ' et ' . $nbr2 . 
                    ' est égale au résultat : ' . ($nbr1 + $nbr2) . '</p>';
                if($nbr1 < 0 && $nbr2 < 0) {
                    $response = '<p>Les deux nombres sont négatifs</p>';
                }
                return new Response($response);
            }
        }*/


    #[Route(path:"/calculatrice/{nbr1}/{nbr2}/{op}", name:"app_accueil_calculatrice")]
    public function calculatrice(mixed $nbr1, mixed $nbr2, string $op){
        $message = '';
        $total = 0;

        if(!is_numeric($nbr1) || !is_numeric($nbr2)){
            $message = '<p>Les données entrées ne sont pas des nombres</p>';
        }
        else{
            switch ($op) {
            case 'add':
                $total = $nbr1 + $nbr2;
                break;
            case 'sous':
                $total = $nbr1 - $nbr2;
                break;
            case 'multi':
                $total = $nbr1 * $nbr2;
                break;
            case 'div':
                if ($nbr2 === 0) {
                    $message = '<p>Erreur: Division par zéro impossible.</p>';
                }
                else{
                    $total = $nbr1 / $nbr2;    
                }  
                break;
     
            default:
                $message = 'Veuillez entrez des paramètres.';
                break;
            }
            $message = '<p>' . $op . ' de ' . $nbr1 . ' et ' . $nbr2 . ' est égale au résultat : ' . $total . '</p>';
        }

        return new Response($message);
    }

}
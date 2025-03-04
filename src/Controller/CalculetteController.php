<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalculetteController extends AbstractController
{
    #[Route('/calculette/{nbr1}/{nbr2}/{op}', name: 'app_calculette')]
    public function index($nbr1, $nbr2, $op): Response
    {
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
        }

        return $this->render('calculette/index.html.twig', [
            'nbr1' => $nbr1,
            'nbr2' => $nbr2,
            'op' => $op,
            'total' => $total,
        ]);
    }  
}

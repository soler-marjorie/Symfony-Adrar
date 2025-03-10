<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository;
use App\Entity\Article;
use App\Entity\Account;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;

final class UserController extends AbstractController
{ 
    public function __construct(
        private readonly AccountRepository $accountRepository
    ) {}

    #[Route('/register', name: 'app_user_register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }

    #[Route('/login', name: 'app_user_login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig');
    }

    #[Route('/account', name: 'app_user_accounts')]
    public function showAllAccounts(): Response
    {
        return $this->render('user/accounts.html.twig', [
            "accounts" => $this->accountRepository->findAll()
        ]);
    }

    #[Route('/account/addAccount', name: 'app_user_addAccount')]
    public function addAccount(Request $resquest): Response
    {
        return $this->render('account/addAccount.html.twig', [
            "accounts" => $this->accountRepository->findAll()
        ]);

        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($resquest);
        $msg = "";
        $status ="";
        if($form->isSubmitted()){
            try {
                $this->em->persist($account);
                $this->em->flush();
                $msg = "La catégorie a été ajoutée avec succès";
                $status = "success";
            } catch (\Exception $e) {
                $msg ="La catégorie existe déja";
                $status = "danger";
            }
        }
        $this->addFlash($status, $msg);
        return $this->render('account/addAccount.html.twig',
        [
            'form'=> $form
        ]);
    }
}

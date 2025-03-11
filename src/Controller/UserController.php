<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository;
use App\Entity\Account;
use App\Form\AccountType;
use App\Service\AccountService;

final class UserController extends AbstractController
{ 
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly AccountService $accountService
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
            "accounts" => $this->accountRepository->getAll()
        ]);
    }

    #[Route('/account/{{id}}', name: 'app_user_accounts_id')]
    public function showById(): Response
    {
        return $this->render('user/findByIdAccount.html.twig', [
            "accounts" => $this->accountRepository->getfindOneById()
        ]);
    }

    #[Route('/account/addAccount', name: 'app_user_addAccount')]
    public function addAccount(Request $request): Response
    {
        $user = new Account();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        $type = "";
        $msg = "";
        //test si le formulaire est submit
        if($form->isSubmitted() && $form->isValid()) {
           try{
            //Appel de la methode save d'AccountService
                $this->accountService->save($user);
                $type ="success";
                $msg = "Le compte à éré ajouté en BDD";
           }
           //Capturer les exceptions
           catch (\Exception $e){
                $type = "danger";
                $msg = $e->getMessage();
           }

            $this->addFlash($type, $msg);
        }
        return $this->render('user/addaccount.html.twig',[
            'formulaire' =>$form
        ]);
    }
}

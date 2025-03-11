<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Account;
use App\Repository\AccountRepository;

class AccountService{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AccountRepository $accountRepository
    ){}

    public function save(Account $account){
        //Tester si les champs sont tous remplis
        if($account->getFirstname() != "" && $account->getLastname() != "" && $account->getEmail() != "" && $account->getPassword() != ""){
            //Test si le compte n'existe pas
            if(!$this->accountRepository->findOneBy(["email"=>$account->getEmail()])){
                //Setter les paramètres
                $account->setRoles("ROLE_USER");
                $this->em->persist($account);
                $this->em->flush();
            }
            else{
                throw new \Exception("Le compte existe déjà", 400);
            }
        }
        //Sinon les champs ne sont pas remplis
        else{
            throw new \Exception("Les champs ne sont pas remplis", 400);
        }
    }

    public function getAll(){
        try {
            $this->accountRepository->findAll();
        } catch (\Exception $e) {
            throw new \Exception("Impossible de récupérer les données.");
        }
    }

    public function getById(int $id){
        try{
            $this->accountRepository->findOneById($id);
        } catch (\Exception $e) {
            throw new \Exception("Impossible de récupérer le compte.");
        }
    }
}
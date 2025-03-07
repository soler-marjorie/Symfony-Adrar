<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ApiAccountController extends AbstractController
{
    public function __construct(
        private AccountRepository $accountRepository
    ) {}


    #[Route('/api/account', name: 'api_account_all')]
    public function getAllAccounts(): Response{
        return $this->json(
            $this->accountRepository->findAll(),
            200,
            [],
            ['groups' => 'account:read']
        );
    }
    
    #[Route('/api/account/update', name: 'api_account_update', methods: ['PUT'])]
    public function updateAccount(Request $request, SerializerInterface $serializer){
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['email'], $data['firstname'], $data['lastname'])) {
            return $this->json(['error' => 'Missing parameters'], 400);
        }

        $account = $this->accountRepository->findOneBy(['email' => $data['email']]);

        if (!$account) {
            return $this->json(['error' => 'Account not found'], 404);
        }

        $account->setFirstname($data['firstname']);
        $account->setLastname($data['lastname']);

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        return $this->json($account, 200, [], ['groups' => 'account:read']);
    }

    #[Route('/api/account/delete/{id}', name: 'api_account_delete', methods: ['DELETE'])]
    public function deleteAccount(int $id): JsonResponse
    {
        $account = $this->accountRepository->find($id);

        if (!$account) {
            return $this->json(['error' => 'Account not found'], 404);
        }

        $this->entityManager->remove($account);
        $this->entityManager->flush();

        return $this->json(['message' => 'Account deleted successfully'], 200);
    }



#[Route('/api/account/update-password', name: 'api_account_update_password', methods: ['PATCH'])]
public function updatePassword(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!isset($data['email'], $data['password'])) {
        return $this->json(['error' => 'Missing email or password'], 400);
    }

    $account = $this->accountRepository->findOneBy(['email' => $data['email']]);

    if (!$account) {
        return $this->json(['error' => 'Account not found'], 404);
    }

    $hashedPassword = $passwordHasher->hashPassword($account, $data['password']);
    $account->setPassword($hashedPassword);

    $this->entityManager->persist($account);
    $this->entityManager->flush();

    return $this->json(['message' => 'Password updated successfully'], 200);
}


}

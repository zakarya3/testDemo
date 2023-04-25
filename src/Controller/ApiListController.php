<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiListController extends AbstractController
{
    #[Route('/api/list', name: 'app_api_list', methods: 'POST')]
    public function list(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $getCnt = json_decode($request->getContent());
        $user = new User();
        $user->setEmail($getCnt->email);
        $user->setFullname($getCnt->fullname);
        $user->setPhone($getCnt->phone);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $getCnt->password,
        );
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(['user'=>$user]);
    }

    // #[Route('/api/list', name: 'app_api_post', methods: 'POST')]
    // public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager)
    // {
    //     $getCnt = json_decode($request->getContent());
    //     $user = new User();
    //     $user->setFullName($getCnt->fullName);
    //     $user->setEmail($getCnt->email);
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    //     return $this->json(['user'=>$user]);
    // }

    #[Route('/api/list/{id}', name: 'app_api_item', methods: 'GET')]
    public function item(UserRepository $userRepository, int $id)
    {
        $user = $userRepository->find($id);
        return $this->json(['data'=>['user' => $user]]);
    }

    // #[Route('/api/list/{id}', name: 'app_api_put', methods: 'PUT')]
    // public function update(UserRepository $userRepository, int $id,Request $request, EntityManagerInterface $entityManager)
    // {
    //     $user = $userRepository->find($id);
    //     $getCnt = json_decode($request->getContent());
    //     $user->setEmail($getCnt->email);
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    //     return $this->json(['user'=>$user]);
    // }

    // #[Route('/api/list/{id}', name: 'app_api_delete', methods: 'DELETE')]
    // public function delete(UserRepository $userRepository, int $id,Request $request, EntityManagerInterface $entityManager)
    // {
    //     $user = $userRepository->find($id);
    //     $entityManager->remove($user);
    //     $entityManager->flush();
    //     return $this->json(['message'=>'user deleted!']);
    // }

}
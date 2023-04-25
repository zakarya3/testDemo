<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\JWTForLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: 'POST')]
    public function login(Request $request, UserPasswordHasherInterface $encoder, JWTForLogin $jwt, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['email'];
        $password = $data['password'];
        $user = $userRepository->findOneBy(['email' => $username]);

        $token = $jwt->generateToken($user);
        return $this->json(['token'=> $token]);
    }
}
<?php
namespace App\Service;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class JWTForLogin
{
    private $jwtManager;
    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function generateToken(User $user)
    {
        $payload = [
            'id' => $user->getId(),
        ];

        return $this->jwtManager->create($user);
    }
}

?>
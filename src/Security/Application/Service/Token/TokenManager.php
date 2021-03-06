<?php

declare(strict_types=1);

namespace App\Security\Application\Service;

use App\Security\Domain\Model\User\User;
use App\Shared\Infrastructure\Framework\Symfony\Security\SecurityUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TokenManager
{
    private JWTTokenManagerInterface $tokenManager;


    public function __construct(JWTTokenManagerInterface $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function generateAccessToken(User $user)
    {
        $securityUser = SecurityUser::createFromDomainUser($user);
        return $this->tokenManager->create($securityUser);
    }
}

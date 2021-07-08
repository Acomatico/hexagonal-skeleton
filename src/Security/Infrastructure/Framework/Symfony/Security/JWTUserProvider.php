<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Model\User\User;
use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTUserProvider implements UserProviderInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername(string $username)
    {
        return $this->userRepository->findByEmail($username);
    }

    public function loadUserByIdentifier(string $identifier)
    {
        return $this->userRepository->findById(UserId::generate($identifier));
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
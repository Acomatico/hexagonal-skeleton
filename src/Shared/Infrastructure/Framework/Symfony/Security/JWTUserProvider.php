<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Model\User\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
        $domainUser = $this->userRepository->findByEmail($username);
        if (!$domainUser) {
            throw new UnauthorizedHttpException('');
        }

        return SecurityUser::createFromDomainUser($domainUser);
    }

    public function loadUserByIdentifier(string $identifier)
    {
        $domainUser = $this->userRepository->findByEmail($identifier);

        if (!$domainUser) {
            throw new UnauthorizedHttpException('');
        }

        return SecurityUser::createFromDomainUser($domainUser);
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass(string $class)
    {
        return SecurityUser::class === $class;
    }
}
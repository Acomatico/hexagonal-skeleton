<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Exception\User\InvalidAuthenticationDataException;
use App\Security\Domain\Model\User\PasswordEncoderInterface;
use App\Security\Domain\Model\User\User;
use App\Shared\Infrastructure\Framework\Symfony\Security\SecurityUser;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    private PasswordHasherFactoryInterface $passwordHasher;

    public function __construct(PasswordHasherFactoryInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function encode(string $password): string
    {
        $hasher =$this->passwordHasher->getPasswordHasher(SecurityUser::class);

        return $hasher->hash($password);
    }

    public function isPasswordValid(User $user, string $password): void
    {
        $securityUser = SecurityUser::createFromDomainUser($user);
        $hasher = $this->passwordHasher->getPasswordHasher($securityUser);

        $isPasswordValid = $hasher->verify($securityUser->getPassword(), $password);

        if (!$isPasswordValid) {
            throw new InvalidAuthenticationDataException();
        }
    }
}

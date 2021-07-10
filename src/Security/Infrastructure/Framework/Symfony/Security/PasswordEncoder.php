<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Exception\User\InvalidAuthenticationDataException;
use App\Security\Domain\Model\User\PasswordEncoderInterface;
use App\Security\Domain\Model\User\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    private PasswordHasherFactoryInterface $passwordHasher;

    public function __construct(PasswordHasherFactoryInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function encode(string $password): string
    {
        $hasher =$this->passwordHasher->getPasswordHasher(User::class);

        return $hasher->hash($password);
    }

    public function isPasswordValid(UserInterface $user, string $password): void
    {
        $hasher = $this->passwordHasher->getPasswordHasher(User::class);

        $isPasswordValid = $hasher->verify($user->getPassword(), $password);

        if (!$isPasswordValid) {
            throw new InvalidAuthenticationDataException();
        }
    }
}

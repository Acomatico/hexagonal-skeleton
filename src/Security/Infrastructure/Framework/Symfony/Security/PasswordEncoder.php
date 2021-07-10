<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Model\User\PasswordEncoderInterface;
use App\Security\Domain\Model\User\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    private PasswordHasherFactoryInterface $passwordHasher;

    public function __construct(PasswordHasherFactoryInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function encode($password): string
    {
        $encoder =$this->passwordHasher->getPasswordHasher(User::class);

        return $encoder->hash($password);
    }
}

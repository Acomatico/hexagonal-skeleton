<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

use Symfony\Component\Security\Core\User\UserInterface;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;

    public function isPasswordValid(UserInterface $user, string $password): void;

}
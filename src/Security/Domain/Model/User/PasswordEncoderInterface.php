<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;

    public function isPasswordValid(User $user, string $password): void;

}
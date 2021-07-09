<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

interface UserRepositoryInterface
{
    public function findById(UserId $id);

    public function findByEmail(string $email);

    public function save(User $user): void;
}
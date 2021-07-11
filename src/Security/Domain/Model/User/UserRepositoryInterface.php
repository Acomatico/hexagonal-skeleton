<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

interface UserRepositoryInterface
{
    public function findById(UserId $id): ?User;

    public function findByEmail(string $email): ?User;

    public function save(User $user): void;

    public function update(User $user): void;
}
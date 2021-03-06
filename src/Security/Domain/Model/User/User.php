<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

class User
{
    private UserId $id;

    private string $email;

    private string $password;

    private array $roles;

    private ?string $salt;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private function __construct(
        UserId $id,
        string $email,
        string $password,
        array $roles,
        ?string $salt,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $updatedAt
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->salt = $salt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(
        UserId $id,
        string $email,
        string $password,
        ?string $salt = null
    ): self
    {
        return new self(
            $id,
            $email,
            $password,
            [],
            $salt,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function salt(): ?string
    {
        return $this->salt;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function update(
        ?string $email,
        ?string $password
    ): void
    {
        if ($email) {
            $this->email = $email;
        }

        if ($password) {
            $this->password = $password;
        }

        if ($email || $password) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
}

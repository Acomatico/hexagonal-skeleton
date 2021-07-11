<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\UpdateUser;

use App\Shared\Application\ServiceRequest;

class UpdateUserCommand implements ServiceRequest
{
    private string $userId;

    private ?string $email;

    private ?string $password;

    public function __construct(string $userId, string $email, string $password)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->email = $email;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}

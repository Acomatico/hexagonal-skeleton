<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\AuthenticateUser;

use App\Shared\Application\ServiceRequest;

class AuthenticateUserCommand implements ServiceRequest
{
    private string $email;

    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
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

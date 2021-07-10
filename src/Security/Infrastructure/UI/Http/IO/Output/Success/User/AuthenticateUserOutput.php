<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\IO\Output\Success\User;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class AuthenticateUserOutput implements JsonOutputInterface
{
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function jsonSerialize(): array
    {
        return [
            'accessToken' => $this->accessToken
        ];
    }
}
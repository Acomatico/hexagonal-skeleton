<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\IO\Output\Error;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class UserNotFoundErrorOutput implements JsonOutputInterface
{
    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'notFound',
                'message' => 'User not found',
                'target' => 'User'
            ]
        ];
    }
}
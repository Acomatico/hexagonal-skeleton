<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\IO\Output\Error;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class BadRequestErrorOutput implements JsonOutputInterface
{
    private string $message;

    private string $target;

    public function __construct(string $message, string $target)
    {
        $this->message = $message;
        $this->target = $target;
    }

    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'badRequest',
                'message' => $this->message,
                'target' => $this->target
            ]
        ];
    }
}

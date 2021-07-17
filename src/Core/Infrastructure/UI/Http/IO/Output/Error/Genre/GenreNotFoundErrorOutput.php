<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Error\Genre;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class GenreNotFoundErrorOutput implements JsonOutputInterface
{
    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'NotFound',
                'message' => 'The genre was not found',
                'target' => 'Genre'
            ]
        ];
    }
}

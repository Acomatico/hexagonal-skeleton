<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class MovieNotFoundErrorOutput implements JsonOutputInterface
{
    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'NotFound',
                'message' => 'The movie was not found',
                'target' => 'Movie'
            ]
        ];
    }
}

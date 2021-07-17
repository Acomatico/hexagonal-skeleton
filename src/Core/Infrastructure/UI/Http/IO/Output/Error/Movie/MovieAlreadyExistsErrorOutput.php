<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class MovieAlreadyExistsErrorOutput implements JsonOutputInterface
{
    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'BadRequest',
                'message' => 'The movie with that title and year already exists',
                'target' => 'Movie'
            ]
        ];
    }
}

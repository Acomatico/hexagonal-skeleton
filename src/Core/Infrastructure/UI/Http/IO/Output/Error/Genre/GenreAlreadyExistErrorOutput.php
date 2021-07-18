<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Error\Genre;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class GenreAlreadyExistErrorOutput implements JsonOutputInterface
{
    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'BadRequest',
                'message' => 'The genre code already exists',
                'target' => 'Genre'
            ]
        ];
    }
}
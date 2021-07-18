<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie;

use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class MovieAlreadyHasGenreErrorOutput implements JsonOutputInterface
{
    private string $genreCode;

    public function __construct(string $genreCode)
    {
        $this->genreCode = $genreCode;
    }

    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'code' => 'BadRequest',
                'message' => sprintf('The movie already has the genre %s', $this->genreCode),
                'target' => 'Movie'
            ]
        ];
    }
}

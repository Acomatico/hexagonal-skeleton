<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Success\Genre;

use App\Core\Domain\Model\Genre\Genre;
use App\Core\Infrastructure\UI\Http\IO\Output\Model\Genre\GenreFactoryOutput;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class GenreOutput implements JsonOutputInterface
{
    private Genre $genre;

    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function jsonSerialize(): array
    {
        return GenreFactoryOutput::serializeGenre($this->genre);
    }
}

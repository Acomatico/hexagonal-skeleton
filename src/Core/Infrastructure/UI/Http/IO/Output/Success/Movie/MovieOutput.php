<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Success\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Infrastructure\UI\Http\IO\Output\Model\Movie\MovieFactoryOutput;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class MovieOutput implements JsonOutputInterface
{
    private Movie $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function jsonSerialize(): array
    {
        return MovieFactoryOutput::serializeMovieFull($this->movie);
    }
}

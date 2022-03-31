<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Success\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieView;
use App\Core\Infrastructure\UI\Http\IO\Output\Model\Movie\MovieFactoryOutput;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\JsonOutputInterface;

class ListMoviesOutput implements JsonOutputInterface
{
    private array $movies;

    public function __construct(array $movies)
    {
        $this->movies = $movies;
    }

    public function jsonSerialize(): array
    {
        $resources =  array_map(function (MovieView $movie) {
            return MovieFactoryOutput::serializeMovieFull($movie);
        }, $this->movies);

        return [
            'resources' => $resources
        ];
    }
}

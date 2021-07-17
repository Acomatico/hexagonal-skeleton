<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Model\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Infrastructure\UI\Http\IO\Output\Model\Genre\GenreFactoryOutput;

class MovieFactoryOutput
{
    public static function serializeMovieFull(Movie $movie): array
    {
        return [
            'id' => $movie->id()->id(),
            'title' => $movie->title(),
            'year' => $movie->year(),
            'description' => $movie->description(),
            'genres' => array_map(function ($genre) {
                return GenreFactoryOutput::serializeGenre($genre);
            }, $movie->genres()->toArray())
        ];
    }
}

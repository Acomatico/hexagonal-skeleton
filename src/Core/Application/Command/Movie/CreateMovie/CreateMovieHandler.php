<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Movie\CreateMovie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieGenres;
use App\Core\Domain\Model\Movie\MovieId;

class CreateMovieHandler
{

    public function handle(CreateMovieCommand $command)
    {
        $movie = Movie::create(
            MovieId::generate(),
            $command->title(),
            $command->year(),
            $command->description(),
            MovieGenres::generate($command->genres())
        );
    }
}
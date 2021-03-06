<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Movie\CreateMovie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieGenres;
use App\Core\Domain\Model\Movie\MovieId;
use App\Core\Domain\Model\Movie\MovieRepositoryInterface;

class CreateMovieHandler
{
    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle(CreateMovieCommand $command): Movie
    {
        $movie = Movie::create(
            MovieId::generate(),
            $command->title(),
            $command->year(),
            $command->description(),
            MovieGenres::generate($command->genres())
        );

        $this->movieRepository->save($movie);

        return $movie;
    }
}

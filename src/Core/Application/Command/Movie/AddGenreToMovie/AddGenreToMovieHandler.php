<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Movie\AddGenreToMovie;

use App\Core\Domain\Exception\Movie\MovieNotFoundException;
use App\Core\Domain\Model\Movie\MovieRepositoryInterface;
use App\Core\Domain\Model\Movie\MovieViewInterface;

class AddGenreToMovieHandler
{
    private MovieRepositoryInterface $movieRepository;

    private MovieViewInterface $movieView;

    public function __construct(MovieRepositoryInterface $movieRepository, MovieViewInterface $movieView)
    {
        $this->movieRepository = $movieRepository;
        $this->movieView = $movieView;
    }

    public function handle(AddGenreToMovieCommand $command)
    {
        $movie = $this->movieView->oneById($command->movieId());
        if (!$movie) {
            throw new MovieNotFoundException();
        }
        $movie->genres()->addGenre($command->genre());
        $this->movieRepository->addGenreToMovies($movie);
    }
}

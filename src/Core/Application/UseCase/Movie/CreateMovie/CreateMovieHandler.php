<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase\Movie\CreateMovie;

use App\Core\Application\Command\Movie\CreateMovie\CreateMovieCommand;
use App\Core\Application\Query\Genre\GetGenreByCode\GetGenreByCodeQuery;
use App\Core\Domain\Exception\Genre\GenreNotFoundException;
use App\Core\Domain\Model\Movie\Movie;
use App\Shared\Infrastructure\QueryBus\QueryBusInterface;
use League\Tactician\CommandBus;

class CreateMovieHandler
{
    private QueryBusInterface $queryBus;

    private CommandBus $commandBus;

    public function __construct(QueryBusInterface $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function handle(CreateMovieRequest $request): Movie
    {
        $userId = $request->userId();

        $genres = [];
        foreach ($request->genres() as $genreCode) {
            $genre = $this->queryBus->query(new GetGenreByCodeQuery($userId, $genreCode));
            if (!$genre) {
                throw new GenreNotFoundException();
            }
            $genres[] = $genre;
        }

        $movie = $this->commandBus->handle(new CreateMovieCommand(
            $request->userId(),
            $request->title(),
            $request->year(),
            $request->description(),
            $genres
        ));

        return $movie;
    }
}
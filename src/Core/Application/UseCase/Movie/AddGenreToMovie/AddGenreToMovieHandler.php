<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase\Movie\AddGenreToMovie;

use App\Core\Application\Command\Movie\AddGenreToMovie\AddGenreToMovieCommand;
use App\Core\Application\Query\Genre\GetGenreByCode\GetGenreByCodeQuery;
use App\Core\Domain\Exception\Genre\GenreNotFoundException;
use App\Shared\Infrastructure\QueryBus\QueryBusInterface;
use League\Tactician\CommandBus;

class AddGenreToMovieHandler
{
    private QueryBusInterface $queryBus;

    private CommandBus $commandBus;

    public function __construct(QueryBusInterface $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function handle(AddGenreToMovieRequest $request)
    {
        $genre = $this->queryBus->query(new GetGenreByCodeQuery($request->userId(), $request->genreCode()));

        if (!$genre) {
            throw new GenreNotFoundException();
        }

        $this->commandBus->handle(new AddGenreToMovieCommand(
            $request->userId(),
            $request->movieId(),
            $genre
        ));
    }
}
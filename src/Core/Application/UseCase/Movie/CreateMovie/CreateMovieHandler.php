<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase\Movie\CreateMovie;

use App\Core\Application\Query\Genre\GetGenreByCode\GetGenreByCodeQuery;
use App\Core\Domain\Model\Genre\GenreViewInterface;
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

    public function handle(CreateMovieRequest $request)
    {
        $userId = $request->userId();

        $genres = $this->queryBus->query(new GetGenreByCodeQuery($userId, $request->genres()[0]));

        dump($genres);
        die('aa');
    }
}
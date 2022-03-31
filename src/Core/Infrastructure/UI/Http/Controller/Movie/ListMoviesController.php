<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Movie;

use App\Core\Application\Query\Movie\ListMovies\ListMoviesQuery;
use App\Core\Infrastructure\UI\Http\IO\Output\Success\Movie\ListMoviesOutput;
use App\Shared\Infrastructure\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class ListMoviesController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Security $security): JsonResponse
    {
        $movies = $this->queryBus->query(new ListMoviesQuery());

        return new JsonResponse(
            new ListMoviesOutput($movies),
            JsonResponse::HTTP_OK
        );
    }
}
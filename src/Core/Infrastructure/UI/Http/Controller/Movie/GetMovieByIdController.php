<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Movie;

use App\Core\Application\Query\Movie\GetMovieById\GetMovieByIdQuery;
use App\Core\Infrastructure\UI\Http\IO\Output\Success\Movie\MovieOutput;
use App\Shared\Infrastructure\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class GetMovieByIdController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request, string $movieId, Security $security)
    {
        $userId = $security->getUser()->getId()->id();
        $movie = $this->queryBus->query(new GetMovieByIdQuery($userId, $movieId));

        return new JsonResponse(
            new MovieOutput($movie),
            JsonResponse::HTTP_OK
        );
    }
}

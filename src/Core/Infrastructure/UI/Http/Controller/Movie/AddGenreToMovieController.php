<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Movie;

use App\Core\Application\UseCase\Movie\AddGenreToMovie\AddGenreToMovieHandler;
use App\Core\Application\UseCase\Movie\AddGenreToMovie\AddGenreToMovieRequest;
use App\Core\Domain\Exception\Genre\GenreNotFoundException;
use App\Core\Domain\Exception\Movie\MovieAlreadyHasThatGenreException;
use App\Core\Domain\Exception\Movie\MovieNotFoundException;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Genre\GenreNotFoundErrorOutput;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie\MovieAlreadyHasGenreErrorOutput;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie\MovieNotFoundErrorOutput;
use App\Shared\Infrastructure\UI\Http\IO\Input\Error\MissingRequiredPropertyError;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class AddGenreToMovieController
{
    private AddGenreToMovieHandler $useCase;

    public function __construct(AddGenreToMovieHandler $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, Security $security, string $movieId)
    {
        $userId = $security->getUser()->getId()->id();
        $genreCode = json_decode($request->getContent(), true)['genre'] ?? null;
        if (null === $genreCode) {
            return new JsonResponse(
                new MultipleInputErrorOutput([new MissingRequiredPropertyError('genre')], 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        try {

            $this->useCase->handle(new AddGenreToMovieRequest(
                $userId,
                $genreCode,
                $movieId
            ));

            return new JsonResponse(
                null,
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (MovieAlreadyHasThatGenreException $exception) {
            return new JsonResponse(
                new MovieAlreadyHasGenreErrorOutput($exception->movieCode()),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (GenreNotFoundException $exception) {
            return new JsonResponse(
                new GenreNotFoundErrorOutput(),
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (MovieNotFoundException $exception) {
            return new JsonResponse(
                new MovieNotFoundErrorOutput(),
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }
}

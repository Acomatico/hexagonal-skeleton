<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Movie;

use App\Core\Application\UseCase\Movie\CreateMovie\CreateMovieHandler;
use App\Core\Application\UseCase\Movie\CreateMovie\CreateMovieRequest;
use App\Core\Domain\Exception\Genre\GenreNotFoundException;
use App\Core\Domain\Exception\Movie\MovieAlreadyExistException;
use App\Core\Infrastructure\UI\Http\IO\Input\Movie\Transformer\CreateMovieTransformer;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Genre\GenreNotFoundErrorOutput;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Movie\MovieAlreadyExistsErrorOutput;
use App\Core\Infrastructure\UI\Http\IO\Output\Success\Movie\MovieOutput;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CreateMovieController
{
    private CreateMovieHandler $useCase;

    private CreateMovieTransformer $transformer;

    public function __construct(CreateMovieHandler $useCase, CreateMovieTransformer $transformer)
    {
        $this->useCase = $useCase;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request, Security $security)
    {
        try {
            $input = $this->transformer->transform($request);

            $movie = $this->useCase->handle(new CreateMovieRequest(
                $security->getUser()->getId()->id(),
                $input->title,
                $input->year,
                $input->description,
                $input->genres ?? []
            ));

            return new JsonResponse(
                new MovieOutput($movie),
                JsonResponse::HTTP_OK
            );
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input')
            );
        } catch (MovieAlreadyExistException $exception) {
            return new JsonResponse(
                new MovieAlreadyExistsErrorOutput(),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (GenreNotFoundException $exception) {
            return new JsonResponse(
                new GenreNotFoundErrorOutput(),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Genre;

use App\Core\Application\Command\Genre\CreateGenre\CreateGenreCommand;
use App\Core\Domain\Exception\Genre\GenreAlreadyExistsException;
use App\Core\Infrastructure\UI\Http\IO\Input\Genre\Transformer\CreateGenreTransformer;
use App\Core\Infrastructure\UI\Http\IO\Output\Error\Genre\GenreAlreadyExistErrorOutput;
use App\Core\Infrastructure\UI\Http\IO\Output\Success\Genre\GenreOutput;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CreateGenreController
{
    private CommandBus $commandBus;

    private CreateGenreTransformer $transformer;

    public function __construct(CommandBus $commandBus, CreateGenreTransformer $transformer)
    {
        $this->commandBus = $commandBus;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request, Security $security)
    {
        try {
            $input = $this->transformer->transform($request);
            $userId = $security->getUser()->getId()->id();

            $genre = $this->commandBus->handle(new CreateGenreCommand(
                $userId,
                $input->name,
                $input->code
            ));

            return new JsonResponse(
                new GenreOutput($genre),
                JsonResponse::HTTP_OK
            );
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (GenreAlreadyExistsException $exception) {
            return new JsonResponse(
                new GenreAlreadyExistErrorOutput(),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}

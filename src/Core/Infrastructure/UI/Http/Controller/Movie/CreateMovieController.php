<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Movie;

use App\Core\Application\UseCase\Movie\CreateMovie\CreateMovieHandler;
use App\Core\Application\UseCase\Movie\CreateMovie\CreateMovieRequest;
use App\Core\Infrastructure\UI\Http\IO\Input\Movie\Transformer\CreateMovieTransformer;
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
        $input = $this->transformer->transform($request);

        $this->useCase->handle(new CreateMovieRequest(
            $security->getUser()->getId()->id(),
            $input->title,
            $input->year,
            $input->description,
            $input->genres ?? []
        ));
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\Controller\Review;

use App\Core\Application\Command\Review\CreateReview\CreateReviewCommand;
use App\Core\Infrastructure\UI\Http\IO\Input\Review\Transformer\CreateReviewTransformer;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CreateReviewController
{
    private CommandBus $commandBus;

    private CreateReviewTransformer $createReviewTransformer;

    public function __construct(CommandBus $commandBus, CreateReviewTransformer $createReviewTransformer)
    {
        $this->commandBus = $commandBus;
        $this->createReviewTransformer = $createReviewTransformer;
    }

    public function __invoke(Request $request, Security $security)
    {
        try {
            $input = $this->createReviewTransformer->transform($request);
            $this->commandBus->handle(new CreateReviewCommand(
                $input->movieId,
                $security->getUser()->getId()->id(),
                $input->title,
                $input->content
            ));

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (\Exception $exception) {
            return new JsonResponse(null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
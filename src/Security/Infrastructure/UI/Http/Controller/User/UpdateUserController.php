<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\Controller\User;

use App\Security\Application\Command\User\UpdateUser\UpdateUserCommand;
use App\Security\Infrastructure\UI\Http\IO\Input\User\Transformer\UpdateUserTransformer;
use App\Security\Infrastructure\UI\Http\IO\Output\Error\UserNotFoundErrorOutput;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;

class UpdateUserController
{
    private CommandBus $commandBus;

    private UpdateUserTransformer $transformer;

    public function __construct(CommandBus $commandBus, UpdateUserTransformer $transformer)
    {
        $this->commandBus = $commandBus;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request, Security $security)
    {
        try {
            $input = $this->transformer->transform($request);

            $this->commandBus->handle(new UpdateUserCommand(
                $security->getUser()->getId()->id(),
                $input->email,
                $input->password
            ));

            return new JsonResponse(
                null,
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (UserNotFoundException $exception) {
            return new JsonResponse(
                new UserNotFoundErrorOutput(),
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

    }
}

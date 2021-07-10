<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\Controller\User;

use App\Security\Application\Command\User\CreateUser\CreateUserCommand;
use App\Security\Infrastructure\UI\Http\IO\Input\User\CreateUserTransformer;
use App\Security\Infrastructure\UI\Http\IO\Output\Error\BadRequestErrorOutput;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateUserController
{
    private CommandBus $commandBus;

    private CreateUserTransformer $transformer;

    public function __construct(CommandBus $commandBus, CreateUserTransformer $transformer)
    {
        $this->commandBus = $commandBus;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request)
    {
        try {
            $input = $this->transformer->transform($request);

            $this->commandBus->handle(new CreateUserCommand(
                $input->email,
                $input->password
            ));

            return new JsonResponse(
                null,
                201
            );
        } catch (BadRequestException $exception) {
            return new JsonResponse(
                new BadRequestErrorOutput($exception->getMessage(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}

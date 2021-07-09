<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\Controller\User;

use App\Security\Application\Command\User\CreateUser\CreateUserCommand;
use App\Shared\Infrastructure\UI\Http\IO\Input\User\CreateUserTransformer;
use League\Tactician\CommandBus;
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
        $input = $this->transformer->transform($request);

        $this->commandBus->handle(new CreateUserCommand(
            $input->email,
            $input->password
        ));

        return new JsonResponse(
            null,
            201
        );
    }
}

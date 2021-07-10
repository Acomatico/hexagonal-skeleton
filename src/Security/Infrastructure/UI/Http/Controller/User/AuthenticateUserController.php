<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\Controller\User;

use App\Security\Application\Command\User\AuthenticateUser\AuthenticateUserCommand;
use App\Security\Infrastructure\UI\Http\IO\Input\User\AuthenticateUserTransformer;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateUserController
{
    private CommandBus $commandBus;

    private AuthenticateUserTransformer $transformer;

    public function __construct(CommandBus $commandBus, AuthenticateUserTransformer $transformer)
    {
        $this->commandBus = $commandBus;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request)
    {
        $input = $this->transformer->transform($request);

        $token = $this->commandBus->handle(new AuthenticateUserCommand(
            $input->email,
            $input->password
        ));
    }
}

<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\Controller\User;

use App\Security\Application\Command\User\AuthenticateUser\AuthenticateUserCommand;
use App\Security\Domain\Exception\User\InvalidAuthenticationDataException;
use App\Security\Infrastructure\UI\Http\IO\Input\User\Transformer\AuthenticateUserTransformer;
use App\Security\Infrastructure\UI\Http\IO\Output\Error\BadRequestErrorOutput;
use App\Security\Infrastructure\UI\Http\IO\Output\Success\User\AuthenticateUserOutput;
use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use App\Shared\Infrastructure\UI\Http\IO\Output\Error\MultipleInputErrorOutput;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        try {
            $input = $this->transformer->transform($request);

            $token = $this->commandBus->handle(new AuthenticateUserCommand(
                $input->email,
                $input->password
            ));

            return new JsonResponse(
                new AuthenticateUserOutput($token),
                JsonResponse::HTTP_OK
            );
        } catch (TransformerException $exception) {
            return new JsonResponse(
                new MultipleInputErrorOutput($exception->errors(), 'input'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (InvalidAuthenticationDataException $exception) {
            return new JsonResponse(
                new BadRequestErrorOutput('Invalid credentials', 'email, password')
            );
        }
    }
}

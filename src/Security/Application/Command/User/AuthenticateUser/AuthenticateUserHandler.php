<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\AuthenticateUser;

use App\Security\Application\Service\TokenManager;
use App\Security\Domain\Exception\User\InvalidAuthenticationDataException;
use App\Security\Domain\Model\User\PasswordEncoderInterface;
use App\Security\Domain\Model\User\UserRepositoryInterface;

class AuthenticateUserHandler
{
    private PasswordEncoderInterface $passwordEncoder;

    private UserRepositoryInterface $userRepository;

    private TokenManager $tokenManager;

    public function __construct(
        PasswordEncoderInterface $passwordEncoder,
        UserRepositoryInterface $userRepository,
        TokenManager $tokenManager
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
    }

    public function handle(AuthenticateUserCommand $command)
    {
        $user = $this->userRepository->findByEmail($command->email());

        if (!$user) {
            throw new InvalidAuthenticationDataException();
        }

        $this->passwordEncoder->isPasswordValid($user, $command->password());

        return $this->tokenManager->generateAccessToken($user);
    }
}

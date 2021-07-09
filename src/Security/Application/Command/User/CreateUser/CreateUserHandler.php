<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\CreateUser;

use App\Security\Application\Service\PasswordEncoder;
use App\Security\Domain\Model\User\User;
use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;

class CreateUserHandler
{
    private UserRepositoryInterface $userRepository;

    private PasswordEncoder $passwordEncoder;

    public function __construct(UserRepositoryInterface $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handle(CreateUserCommand $command): void
    {
        $encodedPassword = $this->passwordEncoder->encode($command->password());
        $user = User::create(
            UserId::generate(),
            $command->email(),
            $encodedPassword
        );

        $this->userRepository->save($user);
    }
}
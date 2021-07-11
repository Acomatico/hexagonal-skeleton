<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\UpdateUser;

use App\Security\Domain\Model\User\PasswordEncoderInterface;
use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UpdateUserHandler
{
    private UserRepositoryInterface $userRepository;

    private PasswordEncoderInterface $passwordEncoder;

    public function __construct(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handle(UpdateUserCommand $command)
    {
        $user = $this->userRepository->findById(UserId::generate($command->userId()));
        if (!$user) {
            throw new UserNotFoundException();
        }
        $encodedNewPassword = $this->passwordEncoder->encode($command->password());

        $user->update(
            $command->email(),
            $encodedNewPassword
        );

        $this->userRepository->update($user);
    }
}

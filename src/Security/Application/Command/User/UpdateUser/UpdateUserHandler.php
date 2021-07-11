<?php

declare(strict_types=1);

namespace App\Security\Application\Command\User\UpdateUser;

use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UpdateUserHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(UpdateUserCommand $command)
    {
        $user = $this->userRepository->findById(UserId::generate($command->userId()));
        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->update(
            $command->email(),
            $command->password()
        );
    }
}

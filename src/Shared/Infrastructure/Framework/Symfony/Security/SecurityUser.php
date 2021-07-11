<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Framework\Symfony\Security;

use App\Security\Domain\Model\User\User;
use App\Security\Domain\Model\User\UserId;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    private UserId $userId;

    private string $username;

    private string $password;

    private ?string $salt;

    private array $roles;

    public function __construct(
        string $userId,
        string $username,
        string $password,
        ?string $salt,
        array $roles
    )
    {
        $this->userId = UserId::generate($userId);
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = $roles;
    }

    public static function createFromDomainUser(User $user): self
    {
        return new self(
            $user->id()->id(),
            $user->email(),
            $user->password(),
            $user->salt(),
            $user->roles()
        );
    }

    public function getId(): UserId
    {
        return $this->userId;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getUserIdentifier()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }
}
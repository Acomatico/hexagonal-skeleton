<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Application\Security\ApplicantId;
use App\Shared\Application\Security\ApplicantInterface;
use App\Shared\Application\Security\ApplicantProviderInterface;
use App\Shared\Application\Security\NullApplicant;
use App\Shared\Application\Security\UserApplicant;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class GenericApplicantProvider implements ApplicantProviderInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function applicant(): ApplicantInterface
    {
        $user = $this->getUserFromToken();

        if (!$user) {
            return new NullApplicant();
        }

        $applicantId = ApplicantId::generate((string) $user->getId());

        return new UserApplicant($applicantId);
    }

    private function getUserFromToken(): ?UserInterface
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token || !is_object($token->getUser())) {
            return null;
        }

        return $token->getUser();
    }
}

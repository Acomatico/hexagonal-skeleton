<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Application\Security\ApplicantInterface;
use App\Shared\Application\Security\ApplicantProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GenericApplicantProvider implements ApplicantProviderInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function applicant(): ApplicantInterface
    {
        $token = $this->tokenStorage->getToken();


    }
}

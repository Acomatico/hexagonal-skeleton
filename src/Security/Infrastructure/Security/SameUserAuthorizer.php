<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Security;

use App\Shared\Application\Security\ApplicantInterface;
use App\Shared\Application\Security\AuthorizerInterface;
use App\Shared\Application\ServiceRequest;

class SameUserAuthorizer implements AuthorizerInterface
{
    public function isAuthorized(ApplicantInterface $applicant, ServiceRequest $request): bool
    {
        $userId = (string) $request->userId();

        return $userId === $applicant->id()->id();
    }
}
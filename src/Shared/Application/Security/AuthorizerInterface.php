<?php

declare(strict_types=1);

namespace App\Shared\Application\Security;

use App\Shared\Application\ServiceRequest;

interface AuthorizerInterface
{
    public function isAuthorized(ApplicantInterface $applicant, ServiceRequest $request): bool;
}
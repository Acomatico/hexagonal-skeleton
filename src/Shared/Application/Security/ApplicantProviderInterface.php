<?php

declare(strict_types=1);

namespace App\Shared\Application\Security;

interface ApplicantProviderInterface
{
    public function applicant(): ApplicantInterface;
}

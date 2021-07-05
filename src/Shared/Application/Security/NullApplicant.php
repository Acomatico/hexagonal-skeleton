<?php

declare(strict_types=1);

namespace App\Shared\Application\Security;

class NullApplicant implements ApplicantInterface
{
    public function id(): ApplicantId
    {
        return ApplicantId::fromString('');
    }
}

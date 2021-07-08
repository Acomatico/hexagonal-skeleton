<?php

declare(strict_types=1);

namespace App\Shared\Application\Security;

class UserApplicant implements ApplicantInterface
{
    private ApplicantId $id;

    public function __construct(ApplicantId $id)
    {
        $this->id = $id;
    }

    public function id(): ApplicantId
    {
        return $this->id;
    }
}

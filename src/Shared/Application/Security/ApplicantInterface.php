<?php

declare(strict_types=1);

namespace App\Shared\Application\Security;

interface  ApplicantInterface
{
    public function id(): ApplicantId;
}
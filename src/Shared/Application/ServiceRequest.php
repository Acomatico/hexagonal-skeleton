<?php

declare(strict_types=1);

namespace App\Shared\Application;

interface ServiceRequest
{
    public function userId(): string;
}

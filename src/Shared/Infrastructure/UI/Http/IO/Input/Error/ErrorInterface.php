<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input\Error;

interface ErrorInterface
{
    public function property(): string;

    public function message(): string;

    public function code(): string;
}
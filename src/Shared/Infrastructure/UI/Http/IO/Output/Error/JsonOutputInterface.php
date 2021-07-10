<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Output\Error;

interface JsonOutputInterface extends \JsonSerializable
{
    public function jsonSerialize(): array;
}

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input\Error;

class InvalidPropertyError implements ErrorInterface
{
    private string $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function code(): string
    {
        return 'InvalidValue';
    }

    public function property(): string
    {
        return $this->property;
    }

    public function message(): string
    {
        return sprintf('Invalid value for property %s', $this->property);
    }
}

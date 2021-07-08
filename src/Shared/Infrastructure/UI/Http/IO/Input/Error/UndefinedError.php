<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input\Error;

class UndefinedError implements ErrorInterface
{
    private string $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function code(): string
    {
        return 'UndefinedError';
    }

    public function property(): string
    {
        return $this->property;
    }

    public function message(): string
    {
        return sprintf('Value for property %s is not valid', $this->property);
    }
}

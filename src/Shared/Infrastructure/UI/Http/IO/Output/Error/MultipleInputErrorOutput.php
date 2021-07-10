<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Output\Error;

use App\Shared\Infrastructure\UI\Http\IO\Input\Error\ErrorInterface;

class MultipleInputErrorOutput implements JsonOutputInterface
{
    private array $errors;

    private string $target;

    public function __construct(array $errors, string $target)
    {
        $this->errors = $errors;
        $this->target = $target;
    }

    public function jsonSerialize(): array
    {
        $response = array_reduce($this->errors, function ($acc, ErrorInterface $error) {
            $parsedError = [
                'code' => $error->code(),
                'message' => $error->message(),
                'target' => $error->property()
            ];

            $acc[$parsedError];

            return $acc;
        }, []);

        return [
            'error' => [
                'code' => 'BadArgument',
                'target' => $this->target,
                'message' => 'Multiple errors in '.$this->target,
                'details' => $response
            ]
        ];
    }
}
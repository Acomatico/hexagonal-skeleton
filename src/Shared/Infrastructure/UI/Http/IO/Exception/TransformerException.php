<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Exception;

use App\Shared\Infrastructure\UI\Http\IO\Input\Error\ErrorInterface;
use Throwable;

class TransformerException extends \Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        $message = implode("\n", array_map(function (ErrorInterface $error) {
            return $error->message();
        }, $errors));
        parent::__construct($message);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}

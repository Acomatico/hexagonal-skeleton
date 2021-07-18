<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception\Movie;

use Throwable;

class MovieAlreadyHasThatGenreException extends \Exception
{
    private string $movieCode;

    public function __construct(string $movieCode, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->movieCode = $movieCode;
        parent::__construct($message, $code, $previous);
    }

    public function movieCode(): string
    {
        return $this->movieCode;
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Genre\CreateGenre;

use App\Shared\Application\ServiceRequest;

class CreateGenreCommand implements ServiceRequest
{
    private string $userId;

    private string $name;

    private string $code;

    public function __construct(string $userId, string $name, string $code)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->code = $code;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function code(): string
    {
        return $this->code;
    }
}

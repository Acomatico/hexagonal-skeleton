<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Genre\GetGenreByCode;

use App\Shared\Application\QueryBus\QueryInterface;

class GetGenreByCodeQuery implements QueryInterface
{
    private string $userId;

    private string $code;

    public function __construct(string $userId, string $code)
    {
        $this->userId = $userId;
        $this->code = $code;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function code(): string
    {
        return $this->code;
    }
}

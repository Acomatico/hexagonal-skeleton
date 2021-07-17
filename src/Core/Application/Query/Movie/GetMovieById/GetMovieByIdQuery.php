<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Movie\GetMovieById;

use App\Shared\Application\QueryBus\QueryInterface;

class GetMovieByIdQuery implements QueryInterface
{
    private string $userId;

    private string $movieId;

    public function __construct(string $userId, string $movieId)
    {
        $this->userId = $userId;
        $this->movieId = $movieId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function movieId(): string
    {
        return $this->movieId;
    }
}

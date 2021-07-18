<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase\Movie\AddGenreToMovie;

class AddGenreToMovieRequest
{
    private string $userId;

    private string $genreCode;

    private string $movieId;

    public function __construct(string $userId, string  $genreCode, string $movieId)
    {
        $this->userId = $userId;
        $this->genreCode = $genreCode;
        $this->movieId = $movieId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function genreCode(): string
    {
        return $this->genreCode;
    }

    public function movieId(): string
    {
        return $this->movieId;
    }
}

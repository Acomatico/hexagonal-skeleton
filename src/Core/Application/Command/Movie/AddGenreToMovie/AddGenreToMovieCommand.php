<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Movie\AddGenreToMovie;

use App\Core\Domain\Model\Genre\Genre;
use App\Shared\Application\ServiceRequest;

class AddGenreToMovieCommand implements ServiceRequest
{
    private string $userId;

    private string $movieId;

    private Genre $genre;

    public function __construct(string $userId, string $movieId, Genre $genre)
    {
        $this->userId = $userId;
        $this->movieId = $movieId;
        $this->genre = $genre;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function movieId(): string
    {
        return $this->movieId;
    }

    public function genre(): Genre
    {
        return $this->genre;
    }
}

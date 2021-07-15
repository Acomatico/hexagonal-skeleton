<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase\Movie\CreateMovie;

class CreateMovieRequest
{
    private string $userId;

    private string $title;

    private string $year;

    private string $description;

    private ?array $genres;

    public function __construct(
        string $userId,
        string $title,
        string $year,
        string $description,
        ?array $genres
    )
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->year = $year;
        $this->description = $description;
        $this->genres = $genres;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function year(): string
    {
        return $this->year;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function genres(): ?array
    {
        return $this->genres;
    }
}
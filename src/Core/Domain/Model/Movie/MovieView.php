<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

class MovieView
{
    private string $id;

    private string $title;

    private string $year;

    private string $description;

    private array $genres;

    private int $reviewCount;

    public function __construct(
        string $id,
        string $title,
        string $year,
        string $description,
        array $genres,
        int $reviewCount
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->description = $description;
        $this->genres = $genres;
        $this->reviewCount = $reviewCount;
    }

    public function id(): string
    {
        return $this->id;
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

    public function genres(): array
    {
        return $this->genres;
    }

    public function reviewCount(): int
    {
        return $this->reviewCount;
    }
}
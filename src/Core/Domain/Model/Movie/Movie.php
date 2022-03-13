<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

use App\Core\Domain\Event\Movie\MovieWasCreatedEvent;
use App\Shared\Domain\Event\DomainEventPublisher;
use App\Shared\Domain\Event\DomainEventRecorder;

class Movie
{
    private MovieId $id;

    private string $title;

    private string $year;

    private string $description;

    private MovieGenres $genres;

    private function __construct(
        MovieId $id,
        string $title,
        string $year,
        string $description,
        MovieGenres $genres
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->description = $description;
        $this->genres = $genres;
    }

    public static function create(
        MovieId $id,
        string $title,
        string $year,
        string $description,
        MovieGenres $genres
    ): self
    {
        DomainEventRecorder::recordThat(new MovieWasCreatedEvent());
        return new self(
            $id,
            $title,
            $year,
            $description,
            $genres
        );
    }

    public function id(): MovieId
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

    public function genres(): MovieGenres
    {
        return $this->genres;
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Review;

use App\Core\Domain\Event\Review\ReviewWasCreatedEvent;
use App\Core\Domain\Model\Movie\MovieId;
use App\Shared\Domain\Event\DomainEventRecorder;

class Review
{
    private ReviewId $id;

    private MovieId $movieId;

    private string $reviewerId;

    private string $title;

    private string $content;

    private function __construct(
        ReviewId $id,
        MovieId $movieId,
        string $reviewerId,
        string $title,
        string $content
    )
    {
        $this->id = $id;
        $this->movieId = $movieId;
        $this->reviewerId = $reviewerId;
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(
        ReviewId $reviewId,
        MovieId $movieId,
        string $reviewerId,
        string $title,
        string $content
    ): self
    {
        DomainEventRecorder::recordThat(new ReviewWasCreatedEvent(
            $movieId,
            $reviewId
        ));
        return new self($reviewId, $movieId, $reviewerId, $title, $content);
    }

    public function id(): ReviewId
    {
        return $this->id;
    }

    public function movieId(): MovieId
    {
        return $this->movieId;
    }

    public function reviewerId(): string
    {
        return $this->reviewerId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }
}

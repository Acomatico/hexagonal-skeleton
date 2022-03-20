<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Review;

use App\Core\Domain\Event\Review\ReviewWasCreatedEvent;
use App\Core\Domain\Model\Movie\MovieId;
use App\Shared\Domain\Event\DomainEventRecorder;

class Review
{
    private ReviewId $reviewId;

    private MovieId $movieId;

    private int $reviewerId;

    private string $title;

    private string $content;

    private function __construct(
        ReviewId $reviewId,
        MovieId $movieId,
        int $reviewerId,
        string $title,
        string $content
    )
    {
        $this->reviewId = $reviewId;
        $this->movieId = $movieId;
        $this->reviewerId = $reviewerId;
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(
        ReviewId $reviewId,
        MovieId $movieId,
        int $reviewerId,
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

    public function reviewId(): ReviewId
    {
        return $this->reviewId;
    }

    public function movieId(): MovieId
    {
        return $this->movieId;
    }

    public function reviewerId(): int
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

<?php

declare(strict_types=1);

namespace App\Core\Domain\Event\Review;

use App\Core\Domain\Model\Movie\MovieId;
use App\Core\Domain\Model\Review\ReviewId;
use App\Shared\Domain\Event\DomainEventInterface;

class ReviewWasCreatedEvent implements DomainEventInterface
{
    private MovieId $movieId;

    private ReviewId $reviewId;

    public function __construct(MovieId $movieId, ReviewId $reviewId)
    {
        $this->movieId = $movieId;
        $this->reviewId = $reviewId;
    }

    public function movieId(): MovieId
    {
        return $this->movieId;
    }

    public function reviewId(): ReviewId
    {
        return $this->reviewId;
    }
}
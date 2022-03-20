<?php

declare(strict_types=1);

namespace App\Core\Application\Listener\Movie;

use App\Core\Domain\Event\Review\ReviewWasCreatedEvent;
use App\Core\Domain\Model\Movie\MovieRepositoryInterface;
use App\Shared\Domain\Event\DomainEventInterface;
use App\Shared\Domain\Event\DomainEventSubscriberInterface;

class AddReviewToMovieListener implements DomainEventSubscriberInterface
{
    private MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle(DomainEventInterface $event): void
    {
        $movie = $this->movieRepository->oneById($event->movieId());
        $movie->addReview();
        $this->movieRepository->save($movie);
    }

    public function isSubscribedTo(DomainEventInterface $event): bool
    {
        return $event instanceof ReviewWasCreatedEvent;
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Review\CreateReview;

use App\Core\Domain\Model\Movie\MovieId;
use App\Core\Domain\Model\Review\Review;
use App\Core\Domain\Model\Review\ReviewId;
use App\Core\Domain\Model\Review\ReviewRepositoryInterface;

class CreateReviewHandler
{
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function handle(CreateReviewCommand $command): void
    {
        $review = Review::create(
            ReviewId::generate(),
            MovieId::generate($command->movieId()),
            $command->userId(),
            $command->title(),
            $command->content()
        );

        $this->reviewRepository->save($review);
    }
}
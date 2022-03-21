<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Review;

use App\Core\Domain\Model\Review\Review;
use App\Core\Domain\Model\Review\ReviewRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLReviewRepository implements ReviewRepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function save(Review $review): void
    {
        $sql = 'INSERT INTO review SET 
                `id` = :id,
                `movie_id` = :movieId,
                `reviewer_id` = :reviewerId,
                `title` = :title,
                `content` = :content';

        $this->connection->executeQuery($sql, $this->saveParameters($review));
    }

    private function saveParameters(Review $review): array
    {
        return [
            'id' => $review->reviewId()->id(),
            'movieId' => $review->movieId()->id(),
            'reviewerId' => $review->reviewerId(),
            'title' => $review->title(),
            'content' => $review->content()
        ];
    }
}
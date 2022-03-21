<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Review;

interface ReviewRepositoryInterface
{
    public function save(Review $review): void;
}
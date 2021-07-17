<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

interface MovieRepositoryInterface
{
    public function save(Movie $movie): void;
}
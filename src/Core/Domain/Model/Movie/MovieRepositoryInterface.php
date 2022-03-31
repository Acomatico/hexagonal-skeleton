<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

interface MovieRepositoryInterface
{
    public function oneById(MovieId $id): ?Movie;

    public function save(Movie $movie): void;

    public function update(Movie $movie): void;

    public function addGenreToMovies(Movie $movie): void;
}
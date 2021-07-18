<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Genre;

interface GenreRepositoryInterface
{
    public function save(Genre $genre): void;

    public function checkGenreIsUnique(Genre $genre): void;

}

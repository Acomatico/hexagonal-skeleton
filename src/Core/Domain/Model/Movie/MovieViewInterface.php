<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

interface MovieViewInterface
{
    public function oneById(string $id): ?MovieView;

    public function listBy() : array;
}
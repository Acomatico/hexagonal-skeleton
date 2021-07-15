<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Genre;

interface GenreViewInterface
{
    public function getOneByCode(string $code): ?Genre;

}

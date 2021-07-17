<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Model\Genre;

use App\Core\Domain\Model\Genre\Genre;

class GenreFactoryOutput
{
    public static function serializeGenre(Genre $genre): array
    {
        return [
            'id' => $genre->id()->id(),
            'name' => $genre->name(),
            'code' => $genre->code()
        ];
    }
}
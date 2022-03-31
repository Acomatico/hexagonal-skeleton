<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Output\Model\Genre;

use App\Core\Domain\Model\Genre\GenreView;

class GenreFactoryOutput
{
    public static function serializeGenre(GenreView $genre): array
    {
        return [
            'id' => $genre->id(),
            'name' => $genre->name(),
            'code' => $genre->code()
        ];
    }
}
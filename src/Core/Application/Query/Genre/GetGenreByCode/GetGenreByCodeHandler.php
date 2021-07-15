<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Genre\GetGenreByCode;

use App\Core\Domain\Model\Genre\GenreViewInterface;

class GetGenreByCodeHandler
{
    private GenreViewInterface $genreView;

    public function __construct(GenreViewInterface $genreView)
    {
        $this->genreView = $genreView;
    }

    public function handle(GetGenreByCodeQuery $query)
    {
        return $this->genreView->getOneByCode($query->code());
    }
}

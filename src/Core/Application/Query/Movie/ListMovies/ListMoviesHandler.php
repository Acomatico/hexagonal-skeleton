<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Movie\ListMovies;

use App\Core\Domain\Model\Movie\MovieViewInterface;

class ListMoviesHandler
{
    private MovieViewInterface $movieView;

    public function __construct(MovieViewInterface $movieView)
    {
        $this->movieView = $movieView;
    }

    public function handle(ListMoviesQuery $query): array
    {
        return $this->movieView->listBy();
    }
}

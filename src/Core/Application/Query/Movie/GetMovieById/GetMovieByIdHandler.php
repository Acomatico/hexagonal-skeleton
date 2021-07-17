<?php

declare(strict_types=1);

namespace App\Core\Application\Query\Movie\GetMovieById;

use App\Core\Domain\Model\Movie\MovieViewInterface;

class GetMovieByIdHandler
{
    private MovieViewInterface $movieView;

    public function __construct(MovieViewInterface $movieView)
    {
        $this->movieView = $movieView;
    }

    public function handle(GetMovieByIdQuery $query)
    {
        return $this->movieView->oneById($query->movieId());
    }
}

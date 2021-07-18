<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Genre\CreateGenre;

use App\Core\Domain\Model\Genre\Genre;
use App\Core\Domain\Model\Genre\GenreId;
use App\Core\Domain\Model\Genre\GenreRepositoryInterface;

class CreateGenreHandler
{
    private GenreRepositoryInterface $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function handle(CreateGenreCommand $command): Genre
    {
        $genre = Genre::generate(
            GenreId::generate(),
            $command->name(),
            $command->code()
        );

        $this->genreRepository->checkGenreIsUnique($genre);
        $this->genreRepository->save($genre);

        return $genre;
    }
}

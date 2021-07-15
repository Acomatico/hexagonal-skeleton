<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLMovieRepository implements MovieRepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function save(Movie $movie): void
    {
        $sql = 'INSERT INTO movie SET
                `id` = :id,
                `title` = :title,
                `year` = :year,
                `description` = :description';

        $parameters = [
            'id' => $movie->id()->id(),
            'title' => $movie->title(),
            'year' => $movie->year(),
            'description' => $movie->description()
        ];

        $this->connection->executeStatement($sql, $parameters);
        $this->saveMovieGenres($movie);
    }

    private function saveMovieGenres(Movie $movie)
    {
        foreach ($movie->genres() as $genre) {
            $sql = 'INSERT INTO movie_genre SET 
                    `movie_id` = :movieId,
                    `genre_id` = :genreId';

            $parameters = [
                'movieId' => $movie->id()->id(),
                'genreId' => $genre->id()->id()
            ];

            $this->connection->executeStatement($sql, $parameters);
        }
    }
}

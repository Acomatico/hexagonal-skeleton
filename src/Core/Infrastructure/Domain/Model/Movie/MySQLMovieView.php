<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Movie;

use App\Core\Domain\Model\Movie\MovieView;
use App\Core\Domain\Model\Movie\MovieViewInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLMovieView implements MovieViewInterface
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function oneById(string $id): ?MovieView
    {
        $sql = 'SELECT * FROM movie WHERE id = :id LIMIT 1';

        $statement = $this->connection->executeQuery($sql, ['id' => $id]);
        if (0 === $statement->rowCount()) {
            return null;
        }

        $movie = $statement->fetchAssociative();
        $genres = $this->getMovieGenres($id);
        $movie['genres'] = $genres;

        return new MovieView(
            $movie['id'],
            $movie['title'],
            $movie['year'],
            $movie['description'],
            $movie['genres'],
            (int) $movie['review_count']
        );
    }

    public function listBy(): array
    {
        $sql = 'SELECT * FROM movie';

        $statement = $this->connection->executeQuery($sql);
        if (0 === $statement->rowCount()) {
            return null;
        }

        $movies = $statement->fetchAllAssociative();

        return array_map(function (array $data) {
            return new MovieView(
                $data['id'],
                $data['title'],
                $data['year'],
                $data['description'],
                [],
                (int) $data['review_count']
            );
        }, $movies);
    }

    private function getMovieGenres(string $movieId): array
    {
        $sql = 'SELECT genre.* FROM genre 
                INNER JOIN movie_genre ON movie_genre.genre_id = genre.id
                WHERE movie_genre.movie_id = :id';

        $statement = $this->connection->executeQuery($sql, ['id' => $movieId]);

        return $statement->fetchAllAssociative();
    }
}

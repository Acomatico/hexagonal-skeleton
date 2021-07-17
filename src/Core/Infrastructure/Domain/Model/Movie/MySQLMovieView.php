<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieViewInterface;
use App\Core\Infrastructure\Domain\Hydrator\Movie\MovieHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLMovieView implements MovieViewInterface
{
    private Connection $connection;

    private MovieHydrator $hydrator;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
        $this->hydrator = new MovieHydrator();
    }

    public function oneById(string $id): ?Movie
    {
        $sql = 'SELECT * FROM movie WHERE id = :id LIMIT 1';

        $statement = $this->connection->executeQuery($sql, ['id' => $id]);
        if (0 === $statement->rowCount()) {
            return null;
        }

        $movie = $statement->fetchAssociative();
        $genres = $this->getMovieGenres($id);
        $movie['genres'] = $genres;

        return $this->hydrate($movie);
    }


    private function getMovieGenres(string $movieId): array
    {
        $sql = 'SELECT genre.* FROM genre 
                INNER JOIN movie_genre ON movie_genre.genre_id = genre.id
                WHERE movie_genre.movie_id = :id';

        $statement = $this->connection->executeQuery($sql, ['id' => $movieId]);

        return $statement->fetchAllAssociative();
    }

    private function hydrate(array $data)
    {
        return $this->hydrator->build($data);
    }
}

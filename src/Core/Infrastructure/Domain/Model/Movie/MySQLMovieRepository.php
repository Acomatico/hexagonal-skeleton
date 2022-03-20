<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Movie;

use App\Core\Domain\Exception\Movie\MovieAlreadyExistException;
use App\Core\Domain\Model\Genre\Genre;
use App\Core\Domain\Model\Genre\GenreId;
use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieId;
use App\Core\Domain\Model\Movie\MovieRepositoryInterface;
use App\Core\Infrastructure\Domain\Hydrator\Movie\MovieHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLMovieRepository implements MovieRepositoryInterface
{
    private Connection $connection;

    private MovieHydrator $movieHydrator;

    public function __construct(EntityManagerInterface $entityManager, MovieHydrator $movieHydrator)
    {
        $this->connection = $entityManager->getConnection();
        $this->movieHydrator = $movieHydrator;
    }

    public function oneById(MovieId $id): ?Movie
    {
        $sql = 'SELECT id, title, year, description, review_count
                FROM movie 
                WHERE id = :id
                LIMIT 1';

        $movieData = $this->connection->executeQuery($sql, ['id' => $id->id()])->fetchAssociative();
        if (!$movieData) {
            return null;
        }

        $movieGenresSql = 'SELECT id, name, code
                            FROM genre
                            INNER JOIN movie_genre ON movie_genre.genre_id = genre.id
                            WHERE movie_genre.movie_id = :movieId';
        $genresData = $this->connection->executeQuery($sql, ['movieId' => $id->id()])->fetchAllAssociative();

        $result = [
            'id' => $movieData['id'],
            'title' => $movieData['title'],
            'year' => $movieData['year'],
            'description' => $movieData['description'],
            'reviewCount' => $movieData['review_count'],
            'genres' => array_map(function (array $genre) {
                return [
                    'id' => $genre['id'],
                    'name' => $genre['name'],
                    'code' => $genre['code']
                ];
            }, $genresData)
        ];

        return $this->movieHydrator->build($result);
    }

    public function save(Movie $movie): void
    {
        $this->checkMovieIsUnique($movie);

        $sql = 'INSERT INTO movie SET
                `id` = :id,
                `title` = :title,
                `year` = :year,
                `description` = :description,
                `review_count` = :reviewCount';

        $parameters = [
            'id' => $movie->id()->id(),
            'title' => $movie->title(),
            'year' => $movie->year(),
            'description' => $movie->description()
        ];

        $this->connection->executeStatement($sql, $parameters);
        $this->saveMovieGenres($movie);
    }

    public function addGenreToMovies(Movie $movie): void
    {
        foreach ($movie->genres() as $genre) {
            $sql = 'SELECT * FROM movie_genre WHERE movie_id = :movieId AND genre_id = :genreId LIMIT 1';
            $movieId = $movie->id();
            $genreId = $genre->id();

            $statement = $this->connection->executeQuery($sql, [
                'movieId' => $movieId->id(),
                'genreId' => $genreId->id()
            ]);

            if (0 < $statement->rowCount()) {
                continue;
            }

            $this->saveMovieGenre($movieId, $genreId);
        }
    }

    public function checkMovieIsUnique(Movie $movie): void
    {
        $sql = 'SELECT id FROM movie WHERE title = :title AND year = :year LIMIT 1';

        $parameters = [
            'title' => $movie->title(),
            'year' => $movie->year()
        ];

        $statement = $this->connection->executeQuery($sql, $parameters);

        if (0 < $statement->rowCount()) {
            throw new MovieAlreadyExistException();
        }
    }

    private function saveMovieGenres(Movie $movie)
    {
        foreach ($movie->genres() as $genre) {
            $this->saveMovieGenre($movie->id(), $genre->id());
        }
    }

    private function saveMovieGenre(MovieId $movieId, GenreId $genreId): void
    {
        $sql = 'INSERT INTO movie_genre SET 
                    `movie_id` = :movieId,
                    `genre_id` = :genreId';

        $parameters = [
            'movieId' => $movieId->id(),
            'genreId' => $genreId->id()
        ];

        $this->connection->executeStatement($sql, $parameters);
    }
}

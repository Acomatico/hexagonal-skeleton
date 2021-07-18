<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Genre;

use App\Core\Domain\Exception\Genre\GenreAlreadyExistsException;
use App\Core\Domain\Model\Genre\Genre;
use App\Core\Domain\Model\Genre\GenreRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLGenreRepository implements GenreRepositoryInterface
{
    private Connection $connection;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function save(Genre $genre): void
    {
        $sql = 'INSERT INTO genre SET 
                id = :id,
                name = :name,
                code = :code';

        $parameters = [
            'id' => $genre->id(),
            'name' => $genre->name(),
            'code' => $genre->code()
        ];

        $this->connection->executeStatement($sql, $parameters);
    }

    public function checkGenreIsUnique(Genre $genre): void
    {
        $sql = 'SELECT id FROM genre WHERE code = :code';

        $parameters = [
            'code' => $genre->code()
        ];

        $statement = $this->connection->executeQuery($sql, $parameters);
        if (0 < $statement->rowCount()) {
            throw new GenreAlreadyExistsException();
        }
    }
}

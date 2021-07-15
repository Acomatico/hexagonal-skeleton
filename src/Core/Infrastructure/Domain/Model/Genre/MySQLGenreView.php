<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Model\Genre;

use App\Core\Domain\Model\Genre\Genre;
use App\Core\Domain\Model\Genre\GenreId;
use App\Core\Domain\Model\Genre\GenreViewInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MySQLGenreView implements GenreViewInterface
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function getOneByCode(string $code): ?Genre
    {
        $sql = 'SELECT * FROM genre WHERE code = :code LIMIT 1';
        $statement = $this->connection->executeQuery($sql, ['code' => $code]);

        if (0 === $statement->rowCount()) {
            return null;
        }

        return $this->hydrate($statement->fetchAssociative());
    }

    private function hydrate(array $data): Genre
    {
        return Genre::generate(
            GenreId::generate($data['id']),
            $data['name'],
            $data['code']
        );
    }
}

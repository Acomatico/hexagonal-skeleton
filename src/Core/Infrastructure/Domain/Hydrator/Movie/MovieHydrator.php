<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Hydrator\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieGenres;
use App\Core\Domain\Model\Movie\MovieId;
use App\Core\Infrastructure\Domain\Hydrator\Genre\GenreHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;

class MovieHydrator
{
    private \ReflectionClass $reflector;

    private HydratorInterface $hydrator;

    private GenreHydrator $genreHydrator;

    public function __construct()
    {
        $this->reflector = new \ReflectionClass(Movie::class);
        $this->hydrator = new ReflectionHydrator();
        $this->genreHydrator = new GenreHydrator();
    }

    public function build(array $data)
    {
        $builtData = [
            'id' => MovieId::generate($data['id']),
            'title' => $data['title'],
            'year' => $data['year'],
            'description' => $data['description'],
            'genres' => MovieGenres::generate(array_map(function ($movie) {
                return $this->genreHydrator->build($movie);
            }, $data['genres']))
        ];


        return $this->hydrator->hydrate(
            $builtData,
            $this->reflector->newInstanceWithoutConstructor()
        );
    }
}
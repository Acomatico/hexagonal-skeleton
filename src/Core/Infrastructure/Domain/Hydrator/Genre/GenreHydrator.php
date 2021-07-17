<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Domain\Hydrator\Genre;

use App\Core\Domain\Model\Genre\Genre;
use App\Core\Domain\Model\Genre\GenreId;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;

class GenreHydrator
{
    private \ReflectionClass $reflector;

    private HydratorInterface $hydrator;

    public function __construct()
    {
        $this->reflector = new \ReflectionClass(Genre::class);
        $this->hydrator = new ReflectionHydrator();
    }

    public function build(array $data)
    {
        $builtData = [
            'id' => GenreId::generate($data['id']),
            'code' => $data['code'],
            'name' => $data['name']
        ];

        return $this->hydrator->hydrate(
            $builtData,
            $this->reflector->newInstanceWithoutConstructor()
        );
    }
}

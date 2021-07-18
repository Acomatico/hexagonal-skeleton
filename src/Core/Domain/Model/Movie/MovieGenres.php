<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Movie;

use App\Core\Domain\Exception\Movie\MovieAlreadyHasThatGenreException;
use App\Core\Domain\Model\Genre\Genre;
use ArrayIterator;
use Countable;
use Iterator;

class MovieGenres implements Iterator, Countable
{
    private ArrayIterator $genres;

    private function __construct(array $genres)
    {
        $this->genres = new ArrayIterator();
        foreach ($genres as $genre) {
            $this->addGenre($genre);
        }
    }

    public static function generateEmpty(): self
    {
        return new self([]);
    }

    public static function generate(array $genres): self
    {
        return new self($genres);
    }

    public function count(): int
    {
        return $this->genres->count();
    }

    public function current()
    {
        return $this->genres->current();
    }

    public function key()
    {
        return $this->genres->key();
    }

    public function next()
    {
        $this->genres->next();
    }

    public function rewind()
    {
        $this->genres->rewind();
    }

    public function valid()
    {
        return $this->genres->valid();
    }

    public function addGenre(Genre $genre): void
    {
        $this->validateGenreIsNotOnIterator($genre);
        $this->genres->append($genre);
    }

    public function toArray(): array
    {
        return $this->genres->getArrayCopy();
    }

    private function validateGenreIsNotOnIterator(Genre $newGenre)
    {
        foreach ($this->genres as $genre) {
            if ($genre->code() === $newGenre->code()) {
                throw new MovieAlreadyHasThatGenreException($newGenre->code());
            }
        }
    }
}
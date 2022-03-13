<?php

declare(strict_types=1);

namespace App\Tests\Core\Domain\Model\Movie;

use App\Core\Domain\Model\Movie\Movie;
use App\Core\Domain\Model\Movie\MovieGenres;
use App\Core\Domain\Model\Movie\MovieId;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    public function testCreateMovie(): void
    {
        $movie = Movie::create(
            MovieId::generate(),
            'some title',
            '1999',
            'description',
            MovieGenres::generateEmpty()
        );

        $this->assertSame('1999', $movie->title());
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Genre;


class Genre
{
    private GenreId $id;

    private string $name;

    private string $code;

    public function __construct(GenreId $id, string $name, string $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    public static function generate(GenreId $id, string $name, string $code): self
    {
        return new self($id, $name, $code);
    }

    public function id(): GenreId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function code(): string
    {
        return $this->code;
    }
}

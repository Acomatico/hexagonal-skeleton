<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Genre;


class GenreView
{
    private string $id;

    private string $name;

    private string $code;

    public function __construct(string $id, string $name, string $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    public function id(): string
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

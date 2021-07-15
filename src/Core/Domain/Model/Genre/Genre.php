<?php

declare(strict_types=1);

namespace App\Core\Domain\Model\Genre;

use App\Shared\Domain\Model\Uuid;

class Genre
{
    private GenreId $id;

    private string $name;

    private string $code;

    public function __construct(Uuid $id, string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public static function generate(Uuid $id, string $name, string $code): self
    {
        return new self($id, $name, $code);
    }

    public function id(): Uuid
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

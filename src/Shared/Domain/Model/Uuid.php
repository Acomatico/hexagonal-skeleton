<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use Ramsey\Uuid\Uuid as BaseUuid;

class Uuid
{
    private string $id;

    private function __construct(string $id)
    {
        $this->isUuidValid($id);
        $this->id = $id;
    }

    public static function generate(?string $id = null): self
    {
        return new static($id ?? BaseUuid::uuid4()->toString());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    private function isUuidValid(string $id): void
    {
        if (!BaseUuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('The class %s doesnt allow the value %s', static::class, $id));
        }
    }
}

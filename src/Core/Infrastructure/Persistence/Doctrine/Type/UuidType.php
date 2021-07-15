<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Domain\Model\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UuidType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array_merge(
            $column,
            [
                'fixed' => true,
                'length' => 36
            ]
        ));
    }

    public function getName()
    {
        return 'uuid';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Uuid) {
            return $value->id();
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Uuid::generate($value);
    }
}

<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Doctrine\Type\User;

use App\Security\Domain\Model\User\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserIdType extends Type
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
        return 'user_id';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserId) {
            return $value->id();
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::generate($value);
    }
}

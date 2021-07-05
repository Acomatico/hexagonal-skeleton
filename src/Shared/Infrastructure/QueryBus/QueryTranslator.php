<?php

declare(strict_types=1);

namespace App\Shared\Application\QueryBus;

class QueryTranslator
{
    public function handlerName(QueryInterface $query): string
    {
        $className = get_class($query);

        $className = substr($className, 0 , - strlen('Query')) . 'Handler';

        return $className;
    }
}
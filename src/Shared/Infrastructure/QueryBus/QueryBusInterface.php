<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\QueryBus;

use App\Shared\Application\QueryBus\QueryInterface;

interface QueryBusInterface
{
    public function query(QueryInterface $query);
}
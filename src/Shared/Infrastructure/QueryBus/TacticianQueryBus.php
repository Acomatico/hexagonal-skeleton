<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\QueryBus;

use App\Shared\Application\QueryBus\QueryInterface;
use League\Tactician\CommandBus;

class TacticianQueryBus implements QueryBusInterface
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function query(QueryInterface $query)
    {
        return $this->commandBus->handle($query);
    }
}

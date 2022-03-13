<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

interface DomainEventBusInterface
{
    public function publish(DomainEventInterface $domainEvent): void;
}
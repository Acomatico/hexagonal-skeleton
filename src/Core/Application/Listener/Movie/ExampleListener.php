<?php

declare(strict_types=1);

namespace App\Core\Application\Listener\Movie;

use App\Core\Domain\Event\Movie\MovieWasCreatedEvent;
use App\Shared\Domain\Event\DomainEventInterface;
use App\Shared\Domain\Event\DomainEventSubscriberInterface;

class ExampleListener implements DomainEventSubscriberInterface
{
    public function handle(DomainEventInterface $event): void
    {
        // TODO: Implement handle() method.
    }

    public function isSubscribedTo(DomainEventInterface $event): bool
    {
        return $event instanceof MovieWasCreatedEvent;
    }
}
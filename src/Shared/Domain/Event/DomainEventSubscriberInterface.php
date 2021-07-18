<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

interface DomainEventSubscriberInterface
{
    public function handle(DomainEventInterface $event): void;

    public function isSubscribedTo(DomainEventInterface $event): bool;
}

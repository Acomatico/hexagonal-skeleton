<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

interface DomainEventPublisherInterface
{
    public static function instance(): self;

    public function publish(DomainEventInterface $event): void;

    public function subscribe(DomainEventSubscriberInterface $subscriber): void;
}

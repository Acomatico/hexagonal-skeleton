<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventBus implements DomainEventBusInterface
{
    private array $subscribers;

    public function __construct(iterable $subscribers)
    {
        foreach (iterator_to_array($subscribers) as $subscriber) {
            $this->subscribe($subscriber);
        }
    }

    public function subscribe(DomainEventSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(DomainEventInterface $domainEvent): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }
}
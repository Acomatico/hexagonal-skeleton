<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventPublisher implements DomainEventPublisherInterface
{
    private array $publishedEvents;

    private static ?DomainEventPublisher $instance = null;

    private function __construct()
    {
        $this->publishedEvents = [];
    }

    public static function instance(): DomainEventPublisherInterface
    {
        if (null === static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function publish(DomainEventInterface $event): void
    {
        $this->publishedEvents[] = $event;
    }

    public function publishedEvents(): array
    {
        return $this->publishedEvents;
    }

    public function clearPublishedEvents(): void
    {
        $this->publishedEvents = [];
    }

}
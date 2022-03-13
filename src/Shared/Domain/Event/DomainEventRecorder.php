<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventRecorder
{
    private array $recordedEvents;

    private static ?self $instance = null;

    private function __construct()
    {
        $this->recordedEvents = [];
    }

    public static function recordedEvents(): array
    {
        return self::instance()->recordedEvents;
    }

    public static function recordThat(DomainEventInterface $domainEvent): void
    {
        self::instance()->recordedEvents[] = $domainEvent;
    }

    public static function clearRecordedEvents(): void
    {
        self::instance()->recordedEvents = [];
    }

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
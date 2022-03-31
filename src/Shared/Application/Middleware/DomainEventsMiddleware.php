<?php

declare(strict_types=1);

namespace App\Shared\Application\Middleware;

use App\Shared\Domain\Event\DomainEventBus;
use App\Shared\Domain\Event\DomainEventBusInterface;
use App\Shared\Domain\Event\DomainEventRecorder;
use League\Tactician\Middleware;

class DomainEventsMiddleware implements Middleware
{
    public DomainEventBusInterface $domainEventsBus;

    public function __construct(DomainEventBusInterface $domainEventBus)
    {
        $this->domainEventsBus = $domainEventBus;
    }

    public function execute($command, callable $next)
    {
        try {
            $result = $next($command);
            foreach (DomainEventRecorder::recordedEvents() as $event) {
                $this->domainEventsBus->publish($event);
            }

            return $result;
        } finally {
            DomainEventRecorder::clearRecordedEvents();
        }
    }
}
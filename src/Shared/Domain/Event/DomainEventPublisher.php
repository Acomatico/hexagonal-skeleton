<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventPublisher implements DomainEventPublisherInterface
{
    private array $subscribers;

    private static ?DomainEventPublisher $instance = null;

    private function __construct()
    {
        $this->subscribers = [];
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
        dump($event);
        die;
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }

    public function subscribe(DomainEventSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

}

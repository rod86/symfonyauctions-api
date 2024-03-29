<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $events = [];

    final public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    final protected function recordEvent(DomainEvent $event): void
    {
        $this->events[] = $event; 
    }

    abstract public function toArray(): array;
}
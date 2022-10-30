<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Utils;
use DateTimeImmutable;

abstract class DomainEvent
{
    private readonly string $aggregateId;
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(
        string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}

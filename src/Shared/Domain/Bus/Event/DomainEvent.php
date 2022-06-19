<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Utils;
use DateTimeImmutable;

abstract class DomainEvent
{
    private string $aggregateId;
    private string $eventId;
    private string $ocurredOn;

    public function __construct(
        string $aggregateId,
        string $eventId = null,
        string $ocurredOn = null
    ) {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->ocurredOn = $ocurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function ocurredOn(): string
    {
        return $this->ocurredOn;
    }
}

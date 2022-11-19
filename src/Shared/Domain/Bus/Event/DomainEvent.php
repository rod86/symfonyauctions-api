<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Utils;
use DateTimeImmutable;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(
        private readonly string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {
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

    public function toArray(): array
    {
        return [
            'id' => $this->eventId,
            'event_type' => static::eventType(),
            'occurred_on' => $this->occurredOn,
            'attributes' => array_merge(
                $this->toPrimitives(),
                ['id' => $this->aggregateId]
            )
        ];
    }

    protected function toPrimitives(): array
    {
        return [];
    }

    abstract public static function eventType(): string;
}
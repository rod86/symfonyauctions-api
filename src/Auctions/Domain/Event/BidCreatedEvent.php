<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class BidCreatedEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $bidId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct(
            aggregateId: $aggregateId,
            eventId: $eventId,
            occurredOn: $occurredOn
        );
    }

    public static function eventType(): string
    {
        return 'auctions.domain.bid_created';
    }

    public function bidId(): string
    {
        return $this->bidId;
    }

    protected function toPrimitives(): array
    {
        return [
            'bid_id' => $this->bidId,
        ];
    }
}
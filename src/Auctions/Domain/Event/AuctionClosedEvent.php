<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class AuctionClosedEvent extends DomainEvent
{
    public static function eventType(): string
    {
        return 'auctions.domain.auction_closed';
    }
}
<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;

final class AuctioneerCannotBidException extends DomainException
{
    public function errorCode(): string
    {
        return 'auctioneer_cannot_bid';
    }

    public function errorMessage(): string
    {
        return 'Auctioneer cannot bid in their auctions';
    }
}
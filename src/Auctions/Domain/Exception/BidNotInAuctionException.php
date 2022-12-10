<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;
use App\Shared\Domain\ValueObject\Uuid;

final class BidNotInAuctionException extends DomainException
{
    public function __construct(
        private readonly Uuid $auctionId,
        private readonly Uuid $bidId
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'bid_not_in_auction';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Bid "%s" could not be found in auction "%s"',
            $this->bidId->value(),
            $this->auctionId->value()
        );
    }
}
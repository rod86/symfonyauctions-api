<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;
use App\Shared\Domain\ValueObject\Uuid;

class AuctionNotAcceptBidsException extends DomainException
{
    public function __construct(private readonly Uuid $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'auction_not_accept_bids';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Auction "%s" cannot accept bids.',
            $this->id->value()
        );
    }
}



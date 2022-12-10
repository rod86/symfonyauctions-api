<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;
use App\Shared\Domain\ValueObject\Uuid;

final class InvalidAuctionStatusException extends DomainException
{
    public function __construct(private readonly Uuid $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_auction_status';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Auction "%s" has an invalid status',
            $this->id->value()
        );
    }
}
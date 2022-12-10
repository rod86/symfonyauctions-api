<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;

final class InvalidBidAmountException extends DomainException
{
    public function errorCode(): string
    {
        return 'invalid_bid_amount';
    }

    public function errorMessage(): string
    {
        return 'Invalid bid amount';
    }
}
<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

final class InvalidAuctionStatusException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid auction status.');
    }
}
<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

final class AuctionBidNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Auction Bid Not found');
    }
}
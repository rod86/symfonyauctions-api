<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

class AuctionNotAcceptBidsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Auction doesn\'t accept bids.');
    }
}



<?php

namespace App\Auctions\Domain\Exception;

class AuctionNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Auction Not found');
    }
}
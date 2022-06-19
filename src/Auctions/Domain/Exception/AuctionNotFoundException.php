<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

class AuctionNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Auction Not found');
    }
}
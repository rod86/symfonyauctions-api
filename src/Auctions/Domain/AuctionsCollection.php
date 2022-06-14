<?php

namespace App\Auctions\Domain;

use App\Shared\Domain\Collection;

class AuctionsCollection extends Collection
{ 
    protected function type(): string
    {
        return Auction::class;
    }
}

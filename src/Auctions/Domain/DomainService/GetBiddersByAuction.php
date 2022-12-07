<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionBid;

final class GetBiddersByAuction
{
    public function __invoke(Auction $auction): array
    {
        $bidders = [];

        /** @var AuctionBid $bid */
        foreach ($auction->bids() as $bid) {
            $key = $bid->user()->id()->value();

            if (!isset($bidders[$key])) {
                $bidders[$key] = $bid->user();
            }
        }

        return array_values($bidders);
    }
}
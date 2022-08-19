<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Contract;

use App\Auctions\Domain\AuctionBid;
use App\Shared\Domain\ValueObject\Uuid;

interface BidRepository
{
    public function create(AuctionBid $bid): void;

    public function findLatestBidByAuctionId(Uuid $auctionId): AuctionBid|null;
}

<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Contract\BidRepository;
use App\Shared\Domain\ValueObject\Uuid;

final class FindLatestBidByAuction
{
    public function __construct(
        private BidRepository $bidRepository
    ) {}

    public function __invoke(Uuid $auctionId): ?AuctionBid
    {
        return $this->bidRepository->findLatestBidByAuctionId($auctionId);
    }
}

<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Exception\AuctionNotAcceptBidsException;
use App\Auctions\Domain\Exception\InvalidBidException;

final class CheckBid
{
    public function __construct(
        private readonly FindLatestBidByAuction $findLatestBidByAuction
    ) {}

    public function __invoke(AuctionBid $bid): void
    {
        $auction = $bid->auction();
        $latestBid = $this->findLatestBidByAuction->__invoke($auction->id());

        if (!$auction->isOpen()) {
            throw new AuctionNotAcceptBidsException();
        }

        if ($bid->user()->id() === $auction->user()->id()) {
            throw new InvalidBidException('Auctioneer cannot bid');
        }

        $latestAmount = $latestBid ? $latestBid->amount() : $auction->initialAmount();

        if ($latestAmount >= $bid->amount()) {
            throw new InvalidBidException('Invalid bid amount');
        }
    }
}

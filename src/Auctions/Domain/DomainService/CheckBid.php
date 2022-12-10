<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Exception\AuctioneerCannotBidException;
use App\Auctions\Domain\Exception\AuctionNotAcceptBidsException;
use App\Auctions\Domain\Exception\InvalidBidAmountException;
use App\Auctions\Domain\Exception\UserOutbidHimselfException;

final class CheckBid
{
    public function __invoke(AuctionBid $bid): void
    {
        $auction = $bid->auction();
        $lastBid = $bid->auction()->getLastBid();

        if (!$auction->isOpen()) {
            throw new AuctionNotAcceptBidsException($auction->id());
        }

        if ($bid->user()->id() === $auction->user()->id()) {
            throw new AuctioneerCannotBidException();
        }

        if ($lastBid && $lastBid->user()->id()->equals($bid->user()->id())) {
            throw new UserOutbidHimselfException();
        }

        $latestAmount = $lastBid ? $lastBid->amount() : $auction->initialAmount();

        if ($latestAmount >= $bid->amount()) {
            throw new InvalidBidAmountException();
        }
    }
}

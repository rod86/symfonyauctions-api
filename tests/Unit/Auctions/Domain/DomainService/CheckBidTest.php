<?php

declare(strict_types=1);

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\DomainService\CheckBid;
use App\Auctions\Domain\Exception\AuctioneerCannotBidException;
use App\Auctions\Domain\Exception\AuctionNotAcceptBidsException;
use App\Auctions\Domain\Exception\InvalidBidAmountException;
use App\Auctions\Domain\Exception\UserOutbidHimselfException;
use App\Tests\Unit\Auctions\Domain\AuctionBidMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use Doctrine\Common\Collections\ArrayCollection;


it('should be a valid bid', function (AuctionBid $bid) {
    $service = new CheckBid();
    $service->__invoke($bid);
})->with(function () {
    // Bid to an auction with no bids
    $auction = AuctionMother::create(
        status: Auction::STATUS_ENABLED
    );
    $bidToCheck = AuctionBidMother::create(
        auction: $auction,
        amount: $auction->initialAmount() + 5,
    );
    yield 'Auction without bids' => $bidToCheck;

    // Auction with bids
    $auction = AuctionMother::create(
        status: Auction::STATUS_ENABLED
    );
    $bids = [];
    $lastBidAmount = $auction->initialAmount();
    for ($i = 0; $i <= 5; $i++) {
        $bid = AuctionBidMother::create(
            auction: $auction,
            amount: $lastBidAmount + 5,
        );
        $bids[$i] = $bid;
        $lastBidAmount = $bid->amount() + 5;
    }
    update_private_property($auction, 'bids', new ArrayCollection($bids));

    $bidToCheck = AuctionBidMother::create(
        auction: $auction,
        amount: $lastBidAmount + 5,
    );
    yield 'auction with bids' => $bidToCheck;

})->expectNotToPerformAssertions();

it('should throw error if auction is not open', function () {
    $auction = AuctionMother::create(
        status: Auction::STATUS_DRAFT
    );
    $bid = AuctionBidMother::create(
        auction: $auction,
        amount: $auction->initialAmount() + 5,
    );

    $service = new CheckBid();
    $service->__invoke($bid);
})->throws(AuctionNotAcceptBidsException::class);

it('should throw error if auctioneer is auction owner', function () {
    $auction = AuctionMother::create(
        status: Auction::STATUS_ENABLED
    );
    $bid = AuctionBidMother::create(
        auction: $auction,
        user: $auction->user(),
        amount: $auction->initialAmount() + 5
    );

    $service = new CheckBid();
    $service->__invoke($bid);
})->throws(AuctioneerCannotBidException::class);

it('should throw error if user has bid before', function () {
    $auction = AuctionMother::create(
        status: Auction::STATUS_ENABLED
    );
    $previousBid = AuctionBidMother::create(
        auction: $auction,
        amount: $auction->initialAmount() + 5
    );
    update_private_property($auction, 'bids', new ArrayCollection([$previousBid]));

    $bid = AuctionBidMother::create(
        auction: $auction,
        user: $previousBid->user(),
        amount: $previousBid->amount() + 5
    );

    $service = new CheckBid();
    $service->__invoke($bid);
})->throws(UserOutbidHimselfException::class);

it('should throw error if amount is invalid', function () {
    $auction = AuctionMother::create(
        status: Auction::STATUS_ENABLED
    );
    $previousBid = AuctionBidMother::create(
        auction: $auction,
        amount: $auction->initialAmount() + 5
    );
    update_private_property($auction, 'bids', new ArrayCollection([$previousBid]));

    $bid = AuctionBidMother::create(
        auction: $auction,
        amount: $previousBid->amount()
    );

    $service = new CheckBid();
    $service->__invoke($bid);
})->throws(InvalidBidAmountException::class);
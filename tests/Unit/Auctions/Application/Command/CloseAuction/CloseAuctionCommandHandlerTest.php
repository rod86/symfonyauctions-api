<?php

declare(strict_types=1);

use App\Auctions\Application\Command\CloseAuction\CloseAuctionCommandHandler;
use App\Auctions\Domain\Auction;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\BidNotInAuctionException;
use App\Auctions\Domain\Exception\InvalidAuctionStatusException;
use App\Tests\Unit\Auctions\Application\Command\CloseAuction\CloseAuctionCommandMother;
use App\Tests\Unit\Auctions\Domain\AuctionBidMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;
use App\Tests\Unit\Auctions\TestCase\FindAuctionByIdMock;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Tests\Unit\Shared\Domain\Repeater;
use App\Tests\Unit\Shared\TestCase\EventBusMock;
use Doctrine\Common\Collections\ArrayCollection;

beforeEach(function () {
    $this->findAuctionByIdMock = new FindAuctionByIdMock($this);
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
    $this->eventBusMock = new EventBusMock($this);
});

it('should close auction', function () {
    $auction = AuctionMother::create(status: Auction::STATUS_ENABLED);
    $bids = new ArrayCollection(
        Repeater::random(fn() => AuctionBidMother::create(auction: $auction, isWinner: false))
    );
    update_private_property($auction, 'bids', $bids);
    $winningBid = $bids->last();

    $command = CloseAuctionCommandMother::create(
        id: $auction->id()->value(),
        bidId: $winningBid->id()->value(),
        userId: $auction->user()->id()->value(),
        closedAt: $winningBid->updatedAt()
    );

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);
    $this->auctionRepositoryMock->shouldUpdateAuction($auction);
    $this->eventBusMock->shouldPublish();

    $handler = new CloseAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        eventBus: $this->eventBusMock->getMock()
    );
    $handler->__invoke($command);
});

it('should throw error if user is not auction owner', function () {
    $auction = AuctionMother::create();
    $command = CloseAuctionCommandMother::create(
        id: $auction->id()->value(),
        userId: FakeValueGenerator::uuid()->value()
    );

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);

    $handler = new CloseAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        eventBus: $this->eventBusMock->getMock()
    );
    $handler->__invoke($command);
})->throws(AuctionNotFoundException::class);

it('should throw error if bid doesn\'t belong to auction', function () {
    $auction = AuctionMother::create(status: Auction::STATUS_ENABLED);
    $winningBid = AuctionBidMother::create();
    update_private_property($auction, 'bids', new ArrayCollection([$winningBid]));

    $command = CloseAuctionCommandMother::create(
        id: $auction->id()->value(),
        bidId: $winningBid->id()->value(),
        userId: $auction->user()->id()->value(),
        closedAt: $winningBid->updatedAt()
    );

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);

    $handler = new CloseAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        eventBus: $this->eventBusMock->getMock()
    );
    $handler->__invoke($command);
})->throws(BidNotInAuctionException::class);

it('should throw error if auction has invalid status', function (Auction $auction) {
    $winningBid = $auction->bids()->last();

    $command = CloseAuctionCommandMother::create(
        id: $auction->id()->value(),
        bidId: $winningBid->id()->value(),
        userId: $auction->user()->id()->value(),
        closedAt: $winningBid->updatedAt()
    );

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);

    $handler = new CloseAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        eventBus: $this->eventBusMock->getMock()
    );
    $handler->__invoke($command);
})->with(function () {
    // Auction with status draft
    $auction = AuctionMother::create(status: Auction::STATUS_DRAFT);
    $bids = new ArrayCollection(
        Repeater::random(fn() => AuctionBidMother::create(auction: $auction, isWinner: false))
    );
    update_private_property($auction, 'bids', $bids);
    yield 'draft auction' => $auction;

    // Auction with status closed and a winning bid
    $auction = AuctionMother::create(status: Auction::STATUS_CLOSED);
    $bids = new ArrayCollection(
        Repeater::random(fn() => AuctionBidMother::create(auction: $auction, isWinner: true))
    );
    update_private_property($auction, 'bids', $bids);
    yield 'closed auction' => $auction;
})->throws(InvalidAuctionStatusException::class);
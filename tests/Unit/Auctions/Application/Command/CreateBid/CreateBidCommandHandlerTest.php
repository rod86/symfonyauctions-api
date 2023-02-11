<?php

declare(strict_types=1);

use App\Auctions\Application\Command\CreateBid\CreateBidCommandHandler;
use App\Tests\Unit\Auctions\Application\Command\CreateBid\CreateBidCommandMother;
use App\Tests\Unit\Auctions\Domain\AuctionBidMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;
use App\Tests\Unit\Auctions\TestCase\CheckBidMock;
use App\Tests\Unit\Auctions\TestCase\FindAuctionByIdMock;
use App\Tests\Unit\Shared\TestCase\EventBusMock;
use App\Tests\Unit\Users\TestCase\FindUserByIdMock;

beforeEach(function () {
    $this->findUserByIdMock = new FindUserByIdMock($this);
    $this->findAuctionByIdMock = new FindAuctionByIdMock($this);
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
    $this->checkBidMock = new CheckBidMock($this);
    $this->eventBusMock = new EventBusMock($this);
});

it('should create bid', function () {
    $bid = AuctionBidMother::create(
        isWinner: false
    );
    $command = CreateBidCommandMother::createFromBid($bid);

    $this->findUserByIdMock->shouldReturnUser($bid->user()->id(), $bid->user());
    $this->findAuctionByIdMock->shouldReturnAuction($bid->auction()->id(), $bid->auction());
    $this->checkBidMock->shouldCheckBid($bid);
    $this->auctionRepositoryMock->shouldUpdateAuction($bid->auction());
    $this->eventBusMock->shouldPublish();

    $handler = new CreateBidCommandHandler(
        findUserById: $this->findUserByIdMock->getMock(),
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        checkBid: $this->checkBidMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        eventBus: $this->eventBusMock->getMock(),
    );
    $handler->__invoke($command);
});
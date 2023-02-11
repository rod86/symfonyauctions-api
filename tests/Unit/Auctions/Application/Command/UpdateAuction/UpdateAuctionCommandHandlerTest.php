<?php

declare(strict_types=1);


use App\Auctions\Application\Command\UpdateAuction\UpdateAuctionCommandHandler;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Tests\Unit\Auctions\Application\Command\UpdateAuction\UpdateAuctionCommandMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;
use App\Tests\Unit\Auctions\TestCase\FindAuctionByIdMock;

beforeEach(function () {
    $this->findAuctionByIdMock = new FindAuctionByIdMock($this);
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
});

it('should update auction', function () {
    $auction = AuctionMother::create();
    $command = UpdateAuctionCommandMother::createFromAuction($auction);

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);
    $this->auctionRepositoryMock->shouldUpdateAuction($auction);

    $handler = new UpdateAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock()
    );
    $handler->__invoke($command);
});


it('should throw error if user is not auction owner', function () {
    $auction = AuctionMother::create();
    $command = UpdateAuctionCommandMother::create(
        id: $auction->id()->value(),
        title: $auction->title(),
        description: $auction->description(),
        initialAmount: $auction->initialAmount(),
        status: $auction->status(),
        updatedAt: $auction->updatedAt()
    );

    $this->findAuctionByIdMock->shouldReturnAuction($auction->id(), $auction);

    $handler = new UpdateAuctionCommandHandler(
        findAuctionById: $this->findAuctionByIdMock->getMock(),
        auctionRepository: $this->auctionRepositoryMock->getMock()
    );
    $handler->__invoke($command);
})->throws(AuctionNotFoundException::class);


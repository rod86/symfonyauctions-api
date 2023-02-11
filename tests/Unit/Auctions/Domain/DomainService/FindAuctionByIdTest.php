<?php

declare(strict_types=1);

use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;

beforeEach(function () {
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
});

it('should return an auction', function () {
    $id = FakeValueGenerator::uuid();
    $auction = AuctionMother::create(id: $id);

    $this->auctionRepositoryMock->shouldFindAuctionById($id, $auction);

    $service = new FindAuctionById(
        auctionRepository: $this->auctionRepositoryMock->getMock()
    );
    $result = $service->__invoke($id);

    expect($result)->toEqual($auction);
});

it('should throw error if auction not found', function () {
    $id = FakeValueGenerator::uuid();

    $this->auctionRepositoryMock->shouldNotFindAuctionById($id);

    $service = new FindAuctionById(
        auctionRepository: $this->auctionRepositoryMock->getMock()
    );
    $service->__invoke($id);
})->throws(AuctionNotFoundException::class);

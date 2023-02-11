<?php

declare(strict_types=1);

use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQueryHandler;
use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdResponse;
use App\Tests\Unit\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQueryMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\FindAuctionByIdMock;

beforeEach(function () {
    $this->findAuctionById = new FindAuctionByIdMock($this);
});

it('should find an auction by id', function () {
    $auction = AuctionMother::create();
    $query = FindAuctionByIdQueryMother::create(
        id: $auction->id()->value()
    );
    $response = new FindAuctionByIdResponse($auction->toArray());

    $this->findAuctionById->shouldReturnAuction($auction->id(), $auction);

    $handler = new FindAuctionByIdQueryHandler(
        findAuctionById: $this->findAuctionById->getMock()
    );
    $result = $handler->__invoke($query);

    expect($result)->toBeQueryResponse($response->data());
});
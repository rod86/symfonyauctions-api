<?php

declare(strict_types=1);

use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQuery;
use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQueryHandler;
use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdResponse;
use App\Tests\Unit\Auctions\Domain\AuctionMother;

beforeEach(function () {
    $this->findAuctionById = null;//new FindAuctionByIdMock($this);
});

it('should find an auction by id', function () {
    $auction = AuctionMother::create();
    $query = new FindAuctionByIdQuery($auction->id()->value());
    $response = new FindAuctionByIdResponse($auction->toArray());

    $this->findAuctionById->shouldReturnUser($auction->id(), $auction);

    $handler = new FindAuctionByIdQueryHandler(
        findAuctionById: $this->findAuctionById->getMock()
    );
    $result = $handler->__invoke($query);

    expect($result)->toBeQueryResponse($response->data());
})->skip('check how mock final');
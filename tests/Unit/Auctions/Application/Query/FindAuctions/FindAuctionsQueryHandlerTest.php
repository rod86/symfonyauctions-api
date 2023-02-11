<?php

declare(strict_types=1);

use App\Auctions\Application\Query\FindAuctions\FindAuctionsQuery;
use App\Auctions\Application\Query\FindAuctions\FindAuctionsQueryHandler;
use App\Tests\Unit\Auctions\Application\Query\FindAuctions\FindAuctionsResponseMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;

beforeEach(function () {
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
});

it('should return an array', function () {
    $auctions = [
        AuctionMother::create(),
        AuctionMother::create(),
        AuctionMother::create(),
    ];

    $response = FindAuctionsResponseMother::create($auctions);

    $this->auctionRepositoryMock->shouldFindAllAuctions($auctions);

    $handler = new FindAuctionsQueryHandler(
        auctionRepository: $this->auctionRepositoryMock->getMock()
    );
    $result = $handler->__invoke(new FindAuctionsQuery());

    expect($result)->toBeQueryResponse($response->data());
});
<?php

declare(strict_types=1);

use App\Auctions\Domain\DomainService\GetBiddersByAuction;
use App\Tests\Unit\Auctions\Domain\AuctionBidMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Users\Domain\UserMother;
use Doctrine\Common\Collections\ArrayCollection;

it('should return an array of bidders', function () {
    $auction = AuctionMother::create();
    $bidders = [
        UserMother::create(),
        UserMother::create(),
        UserMother::create()
    ];
    $bids = [
        AuctionBidMother::create(user: $bidders[0]),
        AuctionBidMother::create(user: $bidders[1]),
        AuctionBidMother::create(user: $bidders[0]),
        AuctionBidMother::create(user: $bidders[2]),
        AuctionBidMother::create(user: $bidders[1]),
    ];

    update_private_property($auction, 'bids', new ArrayCollection($bids));

    $service = new GetBiddersByAuction();
    $result = $service->__invoke($auction);

    expect($result)->toEqual($bidders);
});
<?php

declare(strict_types=1);

use App\Auctions\Application\Command\CreateAuction\CreateAuctionCommandHandler;
use App\Tests\Unit\Auctions\Application\Command\CreateAuction\CreateAuctionCommandMother;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Auctions\TestCase\AuctionRepositoryMock;
use App\Tests\Unit\Users\Domain\UserMother;
use App\Tests\Unit\Users\TestCase\FindUserByIdMock;

beforeEach(function () {
    $this->auctionRepositoryMock = new AuctionRepositoryMock($this);
    $this->findUserByIdMock = new FindUserByIdMock($this);
});

it('should create auction', function () {
    $user = UserMother::create();
    $auction = AuctionMother::create(user: $user);
    $command = CreateAuctionCommandMother::createFromAuction($auction);

    $this->findUserByIdMock->shouldReturnUser($user->id(), $user);
    $this->auctionRepositoryMock->shouldCreateAuction($auction);

    $handler = new CreateAuctionCommandHandler(
        auctionRepository: $this->auctionRepositoryMock->getMock(),
        findUserById: $this->findUserByIdMock->getMock()
    );
    $handler->__invoke($command);
});
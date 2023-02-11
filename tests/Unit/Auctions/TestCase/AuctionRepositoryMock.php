<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\TestCase;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\Contract\AuctionRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;

final class AuctionRepositoryMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return AuctionRepository::class;
    }

    public function shouldFindAllAuctions(array $auctions): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findAllAuctions')
            ->willReturn($auctions);
    }

    public function shouldCreateAuction(Auction $auction): void
    {
        $this->mock
            ->expects($this->once())
            ->method('create')
            ->with($auction);
    }

    public function shouldUpdateAuction(Auction $auction): void
    {
        $this->mock
            ->expects($this->once())
            ->method('update')
            ->with($auction);
    }

    public function shouldFindAuctionById(Uuid $id, Auction $auction): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findOneById')
            ->with($id)
            ->willReturn($auction);
    }

    public function shouldNotFindAuctionById(Uuid $id): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findOneById')
            ->with($id)
            ->willReturn(null);
    }
}
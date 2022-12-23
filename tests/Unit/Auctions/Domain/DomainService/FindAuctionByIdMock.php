<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Domain\DomainService;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;

final class FindAuctionByIdMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return FindAuctionById::class;
    }

    public function shouldReturnUser(Uuid $id, Auction $auction): void
    {
        $this->mock
            ->expects($this->testCase->once())
            ->method('__invoke')
            ->with($id)
            ->willReturn($auction);
    }
}
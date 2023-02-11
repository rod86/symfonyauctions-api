<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\TestCase;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\DomainService\CheckBid;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;

final class CheckBidMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return CheckBid::class;
    }

    public function shouldCheckBid(AuctionBid $bid): void
    {
        $this->mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($bid);
    }
}
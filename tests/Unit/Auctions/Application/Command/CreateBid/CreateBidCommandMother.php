<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Command\CreateBid;

use App\Auctions\Application\Command\CreateBid\CreateBidCommand;
use App\Auctions\Domain\AuctionBid;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use DateTimeImmutable;

final class CreateBidCommandMother
{
    public static function create(
        string $id = null,
        string $userId = null,
        string $auctionId = null,
        float $amount = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): CreateBidCommand {
        return new CreateBidCommand(
            id: $id ?? FakeValueGenerator::uuid()->value(),
            userId: $userId ?? FakeValueGenerator::uuid()->value(),
            auctionId: $auctionId ?? FakeValueGenerator::uuid()->value(),
            amount: $amount ?? FakeValueGenerator::float(),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }

    public static function createFromBid(AuctionBid $bid): CreateBidCommand
    {
        return self::create(
            id: $bid->id()->value(),
            userId: $bid->user()->id()->value(),
            auctionId: $bid->auction()->id()->value(),
            amount: $bid->amount(),
            createdAt: $bid->createdAt(),
            updatedAt: $bid->updatedAt()
        );
    }
}
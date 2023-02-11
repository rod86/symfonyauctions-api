<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Command\UpdateAuction;

use App\Auctions\Application\Command\UpdateAuction\UpdateAuctionCommand;
use App\Auctions\Domain\Auction;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use DateTimeImmutable;

final class UpdateAuctionCommandMother
{
    public static function create(
        string $id = null,
        string $title = null,
        string $description = null,
        float $initialAmount = null,
        string $status = null,
        string $userId = null,
        DateTimeImmutable $updatedAt = null
    ): UpdateAuctionCommand {
        return new UpdateAuctionCommand(
            id: $id ?? FakeValueGenerator::uuid()->value(),
            title: $title ?? FakeValueGenerator::string(),
            description: $description ?? FakeValueGenerator::text(),
            initialAmount: $initialAmount ?? FakeValueGenerator::float(100, 1000),
            status: $status ?? AuctionMother::randomStatus(),
            userId: $userId ?? FakeValueGenerator::uuid()->value(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }

    public static function createFromAuction(Auction $auction): UpdateAuctionCommand
    {
        return self::create(
            id: $auction->id()->value(),
            userId: $auction->user()->id()->value(),
            title: $auction->title(),
            description: $auction->description(),
            initialAmount: $auction->initialAmount(),
            status: $auction->status(),
            updatedAt: $auction->updatedAt()
        );
    }
}
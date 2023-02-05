<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Command\CreateAuction;

use App\Auctions\Application\Command\CreateAuction\CreateAuctionCommand;
use App\Auctions\Domain\Auction;
use App\Tests\Unit\Auctions\Domain\AuctionMother;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use DateTimeImmutable;

final class CreateAuctionCommandMother
{
    public static function create(
        string $id = null,
        string $userId = null,
        string $title = null,
        string $description = null,
        float $initialAmount = null,
        string $status = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): CreateAuctionCommand {
        return new CreateAuctionCommand(
            id: $id ?? FakeValueGenerator::uuid()->value(),
            userId: $userId ?? FakeValueGenerator::uuid()->value(),
            title: $title ?? FakeValueGenerator::string(),
            description: $description ?? FakeValueGenerator::text(),
            initialAmount: $initialAmount ?? FakeValueGenerator::float(100, 1000),
            status: $status ?? AuctionMother::randomStatus(),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }

    public static function createFromAuction(Auction $auction): CreateAuctionCommand
    {
        return self::create(
            id: $auction->id()->value(),
            userId: $auction->user()->id()->value(),
            title: $auction->title(),
            description: $auction->description(),
            initialAmount: $auction->initialAmount(),
            status: $auction->status(),
            createdAt: $auction->createdAt(),
            updatedAt: $auction->updatedAt()
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Domain;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionBid;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Tests\Unit\Users\Domain\UserMother;
use App\Users\Domain\User;
use DateTimeImmutable;

final class AuctionBidMother
{
    public static function create(
        Uuid $id = null,
        Auction $auction = null,
        User $user = null,
        float $amount = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null,
        bool $isWinner = null,
    ): AuctionBid {
        return new AuctionBid(
            id: $id ?? FakeValueGenerator::uuid(),
            auction: $auction ?? AuctionMother::create(),
            user: $user ?? UserMother::create(),
            amount: $amount ?? FakeValueGenerator::float(1000, 10000),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime(),
            isWinner: $isWinner ?? FakeValueGenerator::boolean()
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Domain;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Tests\Unit\Users\Domain\UserMother;
use App\Users\Domain\User;
use DateTimeImmutable;

final class AuctionMother
{
    public static function create(
        Uuid $id = null,
        User $user = null,
        string $title = null,
        string $description = null,
        string $status = null,
        float $initialAmount = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): Auction {
        return new Auction(
            id: $id ?? FakeValueGenerator::uuid(),
            user: $user ?? UserMother::create(),
            title: $title ?? FakeValueGenerator::string(),
            description: $description ?? FakeValueGenerator::text(),
            status: $status ?? FakeValueGenerator::randomElement([
                Auction::STATUS_CLOSED,
                Auction::STATUS_DRAFT,
                Auction::STATUS_ENABLED
            ]),
            initialAmount: $initialAmount ?? FakeValueGenerator::float(100, 10000),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Command\CloseAuction;

use App\Auctions\Application\Command\CloseAuction\CloseAuctionCommand;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use DateTimeImmutable;

final class CloseAuctionCommandMother
{
    public static function create(
        string $id = null,
        string $bidId = null,
        string $userId = null,
        DateTimeImmutable $closedAt = null,
    ): CloseAuctionCommand {
        return new CloseAuctionCommand(
            id: $id ?? FakeValueGenerator::uuid()->value(),
            bidId: $bidId ?? FakeValueGenerator::uuid()->value(),
            userId: $userId ?? FakeValueGenerator::uuid()->value(),
            closedAt: $closedAt ?? FakeValueGenerator::dateTime()
        );
    }
}
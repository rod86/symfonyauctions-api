<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CloseAuction;

use App\Shared\Domain\Bus\Command\Command;

final class CloseAuctionCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $bidId,
        private readonly string $userId,
        private readonly \DateTimeImmutable $closedAt,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function bidId(): string
    {
        return $this->bidId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function closedAt(): \DateTimeImmutable
    {
        return $this->closedAt;
    }
}
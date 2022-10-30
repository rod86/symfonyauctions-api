<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CreateBid;

use DateTimeImmutable;
use App\Shared\Domain\Bus\Command\Command;

final class CreateBidCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $userId,
        private readonly string $auctionId,
        private readonly float $amount,
        private readonly DateTimeImmutable $createdAt,
		private readonly DateTimeImmutable $updatedAt
    ) {}

    public function id(): string
	{
		return $this->id;
	}

	public function userId(): string
	{
		return $this->userId;
	}

    public function auctionId(): string
    {
        return $this->auctionId;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function createdAt(): DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function updatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}
}

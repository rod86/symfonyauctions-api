<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\UpdateAuction;

use App\Shared\Domain\Bus\Command\Command;

final class UpdateAuctionCommand implements Command
{
    public function __construct(
        private readonly string $id,
		private readonly string $title,
		private readonly string $description,
		private readonly float $initialAmount,
		private readonly string $status,
        private readonly string $userId,
		private readonly \DateTimeImmutable $updatedAt
    ) {}

	public function id(): string
	{
		return $this->id;
	}

    public function title(): string
	{
		return $this->title;
	}

    public function description(): string
	{
		return $this->description;
	}

	public function initialAmount(): float
	{
		return $this->initialAmount;
	}

	public function status(): string
	{
		return $this->status;
	}

    public function userId(): string
    {
        return $this->userId;
    }

	public function updatedAt(): \DateTimeImmutable
	{
		return $this->updatedAt;
	}
}

<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\UpdateAuction;

use App\Shared\Domain\Bus\Command\Command;

final class UpdateAuctionCommand implements Command
{
    public function __construct(
        private string $id,
		private string $title,
		private string $description,
		private float $initialAmount,
		private \DateTimeImmutable $updatedAt
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

	public function startDate(): \DateTimeImmutable
	{
		return $this->startDate;
	}

	public function updatedAt(): \DateTimeImmutable
	{
		return $this->updatedAt;
	}
}

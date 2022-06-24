<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\UpdateAuction;

use App\Shared\Domain\Bus\Command\Command;

class UpdateAuctionCommand implements Command
{
    public function __construct(
        private string $id,
		private string $title,
		private string $description,
		private float $startPrice,
		private \DateTimeImmutable $startDate,
		private \DateTimeImmutable $finishDate,
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

	public function startPrice(): float
	{
		return $this->startPrice;
	}

	public function startDate(): \DateTimeImmutable
	{
		return $this->startDate;
	}

	public function finishDate(): \DateTimeImmutable
	{
		return $this->finishDate;
	}

	public function updatedAt(): \DateTimeImmutable
	{
		return $this->updatedAt;
	}
}

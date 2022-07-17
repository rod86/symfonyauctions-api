<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CreateAuction;

use DateTimeImmutable;
use App\Shared\Domain\Bus\Command\Command;

final class CreateAuctionCommand implements Command
{
    public function __construct(
        private string $id,
		private string $userId,
		private string $title,
		private string $description,
		private float $startPrice,
		private \DateTimeImmutable $startDate,
		private \DateTimeImmutable $finishDate,
		private \DateTimeImmutable $createdAt,
		private \DateTimeImmutable $updatedAt
    ) {}

	public function id(): string
	{
		return $this->id;
	}

	public function userId(): string
	{
		return $this->userId;
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

	public function startDate(): DateTimeImmutable
	{
		return $this->startDate;
	}

	public function finishDate(): DateTimeImmutable
	{
		return $this->finishDate;
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

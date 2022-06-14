<?php

namespace App\Auctions\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

final class Auction extends AggregateRoot
{
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';

    private Uuid $id;
    private string $title;
    private string $description;
    private string $status;
    private float $startPrice;
    private \DateTimeImmutable $startDate;
    private \DateTimeImmutable $finishDate;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;


    public function __construct(
        Uuid $id,
        string $title,
        string $description,
        string $status,
        float $startPrice,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $finishDate,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->startPrice = $startPrice;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): Uuid
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

	public function status(): string
	{
		return $this->status;
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

	public function createdAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_price' => $this->startPrice,
            'start_date' => $this->startDate,
            'finish_date' => $this->finishDate,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
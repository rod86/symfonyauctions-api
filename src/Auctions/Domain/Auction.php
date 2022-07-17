<?php

declare(strict_types=1);

namespace App\Auctions\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Aggregate\Timestampable;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;
use DateTimeImmutable;

final class Auction extends AggregateRoot
{
    use Timestampable;

    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';

    public function __construct(
        private Uuid $id,
        private User $user,
        private string $title,
        private string $description,
        private string $status,
        private float $startPrice,
        private DateTimeImmutable $startDate,
        private DateTimeImmutable $finishDate,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->updateCreatedAt($createdAt);
        $this->updateUpdatedAt($updatedAt);
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
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

    public function updateTitle(string $title): void
    {
        $this->title = $title;
    }

    public function updateDescription(string $description): void
    {
        $this->description = $description;
    }

    public function updateStatus(string $status): void
    {
        $this->status = $status;
    }

    public function updateStartPrice(float $startPrice): void
    {
        $this->startPrice = $startPrice;
    }

    public function updateStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function updateFinishDate(DateTimeImmutable $finishDate): void
    {
        $this->finishDate = $finishDate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'user_id' => $this->user->id()->value(),
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
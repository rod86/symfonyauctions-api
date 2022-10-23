<?php

declare(strict_types=1);

namespace App\Auctions\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Aggregate\Timestampable;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Auction extends AggregateRoot
{
    use Timestampable;

    const STATUS_DRAFT = 'draft';
    const STATUS_ENABLED = 'enabled';
    const STATUS_CLOSED = 'closed';

    /** @var Collection|ArrayCollection */
    private Collection $bids;

    public function __construct(
        private Uuid $id,
        private User $user,
        private string $title,
        private string $description,
        private string $status,
        private float $initialAmount,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        private ?AuctionBid $winningBid = null
    ) {
        $this->bids = new ArrayCollection();

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

    public function bids(): Collection
    {
        return $this->bids;
    }

    public function title(): string
    {
        return $this->title;
    }
    
    public function description(): string
    {
        return $this->description;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

	public function status(): string
	{
		return $this->status;
	}

	public function initialAmount(): float
	{
		return $this->initialAmount;
	}

    public function winningBid(): ?AuctionBid
    {
        return $this->winningBid;
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

    public function updateInitialAmount(float $initialAmount): void
    {
        $this->initialAmount = $initialAmount;
    }

    public function updateWinningBid(?AuctionBid $winningBid): void
    {
        $this->winningBid = $winningBid;
    }

    public function addBid(AuctionBid $bid): void 
    {
        $this->bids->add($bid);
    }

    public function isOpen(): bool 
    {
        return $this->status === self::STATUS_ENABLED;
    } 

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'initial_amount' => $this->initialAmount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'user' => $this->user->toArray(),
        ];
    }
}
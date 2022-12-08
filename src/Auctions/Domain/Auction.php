<?php

declare(strict_types=1);

namespace App\Auctions\Domain;

use App\Auctions\Domain\Event\AuctionClosedEvent;
use App\Auctions\Domain\Event\BidCreatedEvent;
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

    /** @var Collection */
    private Collection $bids;

    public function __construct(
        private Uuid $id,
        private readonly User $user,
        private string $title,
        private string $description,
        private string $status,
        private float $initialAmount,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->bids = new ArrayCollection();

        $this->updateCreatedAt($createdAt);
        $this->updateUpdatedAt($updatedAt);
    }

    public static function create(
        Uuid $id,
        User $user,
        string $title,
        string $description,
        string $status,
        float $initialAmount,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ): self {
        return new self(
            id: $id,
            user: $user,
            title: $title,
            description: $description,
            status: $status,
            initialAmount: $initialAmount,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
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

	public function initialAmount(): float
	{
		return $this->initialAmount;
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

    public function close(AuctionBid $bid, DateTimeImmutable $closedAt): void
    {
        $bid->updateIsWinner(true);
        $bid->updateUpdatedAt($closedAt);
        $this->updateStatus(self::STATUS_CLOSED);
        $this->updateUpdatedAt($closedAt);
        $this->recordEvent(new AuctionClosedEvent(
            aggregateId: $this->id->value()
        ));
    }

    public function updateInitialAmount(float $initialAmount): void
    {
        $this->initialAmount = $initialAmount;
    }

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_ENABLED;
    }

    public function bids(): Collection
    {
        return $this->bids;
    }

    public function addBid(AuctionBid $bid): void
    {
        $this->bids->add($bid);
        $this->recordEvent(new BidCreatedEvent(
            aggregateId: $this->id->value(),
            bidId: $bid->id()->value()
        ));
    }

    public function getBidById(Uuid $id): ?AuctionBid
    {
        /** @var AuctionBid $item */
        foreach ($this->bids as $item) {
            if ($item->id()->equals($id)) {
                return $item;
            }
        }

        return null;
    }

    public function getLastBid(): ?AuctionBid
    {
        $bid = $this->bids->first();
        return ($bid !== false) ? $bid : null;
    }

    public function updateWinningBid(Uuid $id): void
    {
        $bid = $this->getBidById($id);

        if (!$bid) {
            return;
        }

        $bid->updateIsWinner(true);
    }

    public function winningBid(): ?AuctionBid
    {
        $bid = $this->bids->filter(
            fn(AuctionBid $item) => $item->isWinner()
        )->first();
        return ($bid !== false) ? $bid : null;
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
            'bids' => array_map(fn($item) => $item->toArray(), $this->bids->toArray())
        ];
    }
}
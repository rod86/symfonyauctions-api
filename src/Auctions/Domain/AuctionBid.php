<?php

declare(strict_types=1);

namespace App\Auctions\Domain;

use App\Shared\Domain\Aggregate\Timestampable;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;
use DateTimeImmutable;

class AuctionBid
{
    use Timestampable;

    public function __construct(
        private Uuid $id,
        private readonly Auction $auction,
        private readonly User $user,
        private readonly float $amount,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        private bool $isWinner = false,
    ) {
        $this->updateCreatedAt($createdAt);
        $this->updateUpdatedAt($updatedAt);
    }

    public static function create(
        Uuid $id,
        Auction $auction,
        User $user,
        float $amount,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        bool $isWinner = false,
    ): self {
        return new self(
            id: $id,
            auction: $auction,
            user: $user,
            amount: $amount,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            isWinner: $isWinner
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

    public function auction(): Auction
    {
        return $this->auction;
    }
    
    public function amount(): float
    {
        return $this->amount;
    }

    public function isWinner(): bool
    {
        return $this->isWinner;
    }

    public function updateIsWinner(bool $value): void
    {
        $this->isWinner = $value;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'amount' => $this->amount,
            'is_winner' => $this->isWinner,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'auction' => $this->auction->id()->value(),
            'user' => $this->user->toArray(),
        ];
    }
}

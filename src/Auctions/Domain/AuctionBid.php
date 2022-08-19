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
        private Auction $auction,
        private User $user,
        private float $amount,
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

    public function auction(): Auction
    {
        return $this->auction;
    }
    
    public function amount(): float
    {
        return $this->amount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'amount' => $this->amount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'auction' => $this->auction->id()->value(),
            'user' => $this->user->toArray(),
        ];
    }
}

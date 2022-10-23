<?php

declare(strict_types=1);

namespace App\UI\Fixture\Factory;

use App\Auctions\Domain\AuctionBid;
use App\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;

final class AuctionBidFactory extends ModelFactory
{
    protected function getModelClass(): string
    {
        return AuctionBid::class;
    }

    protected function getDefaultAttributes(): array
    {
        return [
            'id' => Uuid::random(),
            'auction' => AuctionFactory::new()->createOne(),
            'user' => UserFactory::new()->createOne(),
            'amount' => $this->faker()->randomFloat(2, 1),
            'createdAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year')),
            'updatedAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year'))
        ];
    }
}
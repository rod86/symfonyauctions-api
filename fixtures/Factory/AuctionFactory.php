<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;

final class AuctionFactory extends ModelFactory
{
    protected function getModelClass(): string
    {
        return Auction::class;
    }

    protected function getDefaultAttributes(): array
    {
        return [
            'id' => Uuid::random(),
            'user' => UserFactory::new()->createOne(),
            'title' => $this->faker()->text(100),
            'description' => $this->faker()->paragraph(),
            'status' => $this->faker()->randomElement([
                Auction::STATUS_DRAFT,
                Auction::STATUS_CLOSED,
                Auction::STATUS_ENABLED
            ]),
            'initialAmount' => $this->faker()->randomFloat(2, 1, 10000),
            'winningBid' => null,
            'createdAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year')),
            'updatedAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year'))
        ];
    }
}
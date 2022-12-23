<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Query\FindAuctionById;

use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQuery;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;

final class FindAuctionByIdQueryMother
{
    public static function create(
        string $id = null,
    ): FindAuctionByIdQuery {
        return new FindAuctionByIdQuery(
            id: $id ?? FakeValueGenerator::uuid()->value()
        );
    }
}
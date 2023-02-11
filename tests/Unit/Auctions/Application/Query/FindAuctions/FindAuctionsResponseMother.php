<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auctions\Application\Query\FindAuctions;

use App\Auctions\Application\Query\FindAuctions\FindAuctionsResponse;
use App\Shared\Domain\Aggregate\AggregateRoot;
use function Lambdish\Phunctional\map;

final class FindAuctionsResponseMother
{
    public static function create(array $auctions): FindAuctionsResponse
    {
        $auctions = map(fn (AggregateRoot $item) => $item->toArray(), $auctions);
        return new FindAuctionsResponse($auctions);
    }
}
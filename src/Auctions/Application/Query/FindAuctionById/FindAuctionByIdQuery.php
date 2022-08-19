<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Shared\Domain\Bus\Query\Query;

final class FindAuctionByIdQuery implements Query
{
    public function __construct(
        private string $id
    ) {}

    public function id(): string
    {
        return $this->id;
    }
}

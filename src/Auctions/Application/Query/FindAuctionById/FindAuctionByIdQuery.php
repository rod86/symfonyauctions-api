<?php

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Shared\Domain\Bus\Query\Query;

class FindAuctionByIdQuery implements Query
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}

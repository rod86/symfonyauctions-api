<?php

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\Bus\Query\Response;

class FindAuctionByIdResponse implements Response
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function data(): array
    {
        return $this->data;
    }
}
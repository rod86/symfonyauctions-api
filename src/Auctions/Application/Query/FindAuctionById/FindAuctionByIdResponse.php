<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Shared\Domain\Bus\Query\Response;

class FindAuctionByIdResponse implements Response
{
    public function __construct(
        private array $data
    ) {}

    public function data(): array
    {
        return $this->data;
    }
}
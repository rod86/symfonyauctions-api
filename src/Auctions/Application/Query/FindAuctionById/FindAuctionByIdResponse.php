<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Shared\Domain\Bus\Query\Response;

final class FindAuctionByIdResponse implements Response
{
    public function __construct(
        private readonly array $data
    ) {}

    public function data(): array
    {
        return $this->data;
    }
}
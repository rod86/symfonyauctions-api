<?php

namespace App\Auctions\Application\Query\FindAuctions;

use App\Auctions\Domain\AuctionsCollection;
use App\Shared\Domain\Bus\Query\Response;

final class FindAuctionsResponse implements Response
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

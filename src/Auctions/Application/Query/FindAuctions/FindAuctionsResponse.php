<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctions;

use App\Shared\Domain\Bus\Query\Response;

final class FindAuctionsResponse implements Response
{
    public function __construct(
        private array $data
    ) {}

    public function data(): array
    {
        return $this->data;
    }
}

<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Contract;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\ValueObject\Uuid;
use App\Auctions\Domain\AuctionsCollection;

interface AuctionRepository
{
    public function create(Auction $auction): void;

    public function update(Auction $auction): void;

    public function findAllAuctions(): array;

    public function findOneById(Uuid $id): Auction|null; 
}
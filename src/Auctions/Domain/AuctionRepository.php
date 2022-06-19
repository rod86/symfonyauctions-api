<?php

declare(strict_types=1);

namespace App\Auctions\Domain;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\ValueObject\Uuid;

interface AuctionRepository
{
    public function create(Auction $auction): void;

    public function findAllAuctions(): AuctionsCollection;

    public function findOneById(Uuid $id): ?Auction; 
}
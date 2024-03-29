<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\Contract\AuctionRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Auctions\Domain\Exception\AuctionNotFoundException;

final class FindAuctionById
{
    public function __construct(
       private readonly AuctionRepository $auctionRepository
    ) {}

    public function __invoke(Uuid $id): Auction
    {
        $auction = $this->auctionRepository->findOneById($id);

        if ($auction === null) {
            throw new AuctionNotFoundException($id);
        }

        return $auction;
    }
}

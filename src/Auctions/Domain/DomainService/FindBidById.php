<?php

declare(strict_types=1);

namespace App\Auctions\Domain\DomainService;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Contract\BidRepository;
use App\Auctions\Domain\Exception\AuctionBidNotFoundException;
use App\Shared\Domain\ValueObject\Uuid;

final class FindBidById
{
    public function __construct(
        private readonly BidRepository $bidRepository
    ) {}

    public function __invoke(Uuid $id): AuctionBid
    {
        $bid = $this->bidRepository->findOneById($id);

        if ($bid === null) {
            throw new AuctionBidNotFoundException();
        }

        return $bid;
    }
}
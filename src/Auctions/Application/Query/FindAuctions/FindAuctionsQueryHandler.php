<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctions;

use App\Auctions\Domain\Contracts\AuctionRepository;
use App\Shared\Domain\Bus\Query\QueryHandler;

final class FindAuctionsQueryHandler implements QueryHandler
{
    public function __construct(
        private AuctionRepository $auctionRepository
    ) {}

    public function __invoke(FindAuctionsQuery $query): FindAuctionsResponse
    {
        $auctions = $this->auctionRepository->findAllAuctions();
        
        return new FindAuctionsResponse($auctions->toArray());
    }
}

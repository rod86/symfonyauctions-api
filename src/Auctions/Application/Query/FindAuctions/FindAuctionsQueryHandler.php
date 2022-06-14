<?php

namespace App\Auctions\Application\Query\FindAuctions;

use App\Auctions\Domain\AuctionRepository;
use App\Shared\Domain\Bus\Query\QueryHandler;

final class FindAuctionsQueryHandler implements QueryHandler
{
    private AuctionRepository $auctionRepository;

    public function __construct(AuctionRepository $auctionRepository)
    {
        $this->auctionRepository = $auctionRepository;
    }

    public function __invoke(FindAuctionsQuery $query): FindAuctionsResponse
    {
        $auctions = $this->auctionRepository->findAllAuctions();
        
        return new FindAuctionsResponse($auctions->toArray());
    }
}

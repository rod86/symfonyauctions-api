<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctions;

use App\Auctions\Domain\Contract\AuctionRepository;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Bus\Query\QueryHandler;
use function Lambdish\Phunctional\map;

final class FindAuctionsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly AuctionRepository $auctionRepository
    ) {}

    public function __invoke(FindAuctionsQuery $query): FindAuctionsResponse
    {
        $auctions = $this->auctionRepository->findAllAuctions();
        $auctions = map(fn (AggregateRoot $item) => $item->toArray(), $auctions);
        
        return new FindAuctionsResponse($auctions);
    }
}

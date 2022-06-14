<?php

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Auctions\Domain\AuctionRepository;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\ValueObject\Uuid;
use Exception;

class FindAuctionByIdQueryHandler implements QueryHandler
{
    private AuctionRepository $auctionRepository;

    public function __construct(AuctionRepository $auctionRepository)
    {
        $this->auctionRepository = $auctionRepository;    
    }

    public function __invoke(FindAuctionByIdQuery $query): FindAuctionByIdResponse
    {
        $auction = $this->auctionRepository->findOneById(
            Uuid::fromString($query->id())
        );

        if (!$auction) {
            throw new AuctionNotFoundException($query->id());
        }

        return new FindAuctionByIdResponse($auction->toArray());
    }
}

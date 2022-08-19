<?php

declare(strict_types=1);

namespace App\Auctions\Application\Query\FindAuctionById;

use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\ValueObject\Uuid;

final class FindAuctionByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private FindAuctionById $findAuctionById
    ) {}

    public function __invoke(FindAuctionByIdQuery $query): FindAuctionByIdResponse
    {
        $auction = $this->findAuctionById->__invoke(
            Uuid::fromString($query->id())
        );

        return new FindAuctionByIdResponse($auction->toArray());
    }
}

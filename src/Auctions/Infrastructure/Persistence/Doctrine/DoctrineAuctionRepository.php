<?php

namespace App\Auctions\Infrastructure\Persistence\Doctrine;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionRepository;
use App\Auctions\Domain\AuctionsCollection;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineAuctionRepository extends DoctrineRepository implements AuctionRepository
{
    protected function entityClass(): string
    {
        return Auction::class;
    }

    public function create(Auction $auction): void
    {
        $this->persist($auction);
    }

    public function findAllAuctions(): AuctionsCollection
    {
        $result = $this->repository()->findAll();

        return new AuctionsCollection($result);
    }

    public function findOneById(Uuid $id): ?Auction
    {
        return $this->repository()->findOneById($id->value());
    }
}

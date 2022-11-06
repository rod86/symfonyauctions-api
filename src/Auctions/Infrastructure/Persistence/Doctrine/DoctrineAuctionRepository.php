<?php

declare(strict_types=1);

namespace App\Auctions\Infrastructure\Persistence\Doctrine;

use App\Auctions\Domain\Auction;
use App\Shared\Domain\ValueObject\Uuid;
use App\Auctions\Domain\AuctionsCollection;
use App\Auctions\Domain\Contract\AuctionRepository;
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

    public function update(Auction $auction): void
    {
        $this->updateEntity();
    }

    public function findAllAuctions(): AuctionsCollection
    {
        $result = $this->repository()->findAll();

        return new AuctionsCollection($result);
    }

    public function findOneById(Uuid $id): Auction|null
    {
        return $this->repository()->findOneById($id->value());
    }
}

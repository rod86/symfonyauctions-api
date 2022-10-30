<?php

declare(strict_types=1);

namespace App\Auctions\Infrastructure\Persistence\Doctrine;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Contract\BidRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineBidRepository extends DoctrineRepository implements BidRepository
{
    protected function entityClass(): string
    {
        return AuctionBid::class;
    }

    public function create(AuctionBid $bid): void
    {
        $this->persist($bid);
    }

    public function update(AuctionBid $bid): void
    {
        $this->updateEntity($bid);
    }

    public function findLatestBidByAuctionId(Uuid $auctionId): AuctionBid|null
    {   
        return $this->repository()->createQueryBuilder('b')
            ->where('b.auction = :auction')
            ->orderBy('b.createdAt', 'DESC')
            ->setMaxResults(1)
            ->setParameter('auction', $auctionId, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneById(Uuid $id): AuctionBid|null
    {
        return $this->repository()->findOneById($id->value());
    }
}

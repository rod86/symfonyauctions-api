<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CreateBid;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Contract\BidRepository;
use App\Auctions\Domain\DomainService\CheckBid;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\DomainService\FindUserById;

final class CreateBidCommandHandler implements CommandHandler
{
    public function __construct(
        private FindUserById $findUserById,
        private FindAuctionById $findAuctionById,
        private CheckBid $checkBid,
        private BidRepository $bidRepository,
    ) {}

    public function __invoke(CreateBidCommand $command): void
    {
        $user = $this->findUserById->__invoke(Uuid::fromString($command->userId()));

        $auction = $this->findAuctionById->__invoke(Uuid::fromString($command->auctionId()));

        $bid = new AuctionBid(
            Uuid::random(),
            $auction,
            $user,
            $command->amount(),
            $command->createdAt(),
            $command->updatedAt()
        );

        $this->checkBid->__invoke($bid);

        $this->bidRepository->create($bid);

        // TODO event to notify all auction users that bidded
    }
}

<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CreateBid;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\Contract\AuctionRepository;
use App\Auctions\Domain\DomainService\CheckBid;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\DomainService\FindUserById;

final class CreateBidCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FindUserById $findUserById,
        private readonly FindAuctionById $findAuctionById,
        private readonly CheckBid $checkBid,
        private readonly AuctionRepository $auctionRepository,
        private readonly EventBus $eventBus
    ) {}

    public function __invoke(CreateBidCommand $command): void
    {
        $user = $this->findUserById->__invoke(Uuid::fromString($command->userId()));

        $auction = $this->findAuctionById->__invoke(Uuid::fromString($command->auctionId()));

        $bid = AuctionBid::create(
            Uuid::fromString($command->id()),
            $auction,
            $user,
            $command->amount(),
            $command->createdAt(),
            $command->updatedAt()
        );

        $this->checkBid->__invoke($bid);

        $auction->addBid($bid);
        $this->auctionRepository->update($auction);

        $this->eventBus->publish(...$auction->pullEvents());
    }
}

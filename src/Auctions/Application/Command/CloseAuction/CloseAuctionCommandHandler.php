<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CloseAuction;

use App\Auctions\Domain\Contract\AuctionRepository;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\BidNotInAuctionException;
use App\Auctions\Domain\Exception\InvalidAuctionStatusException;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class CloseAuctionCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FindAuctionById $findAuctionById,
        private readonly AuctionRepository $auctionRepository,
        private readonly EventBus $eventBus
    ) {}

    public function __invoke(CloseAuctionCommand $command): void
    {
        $auctionId = Uuid::fromString($command->id());
        $bidId = Uuid::fromString($command->bidId());

        $auction = $this->findAuctionById->__invoke($auctionId);

        if (!$auction->user()->id()->equals(Uuid::fromString($command->userId()))) {
            throw new AuctionNotFoundException($auctionId);
        }

        $bid = $auction->getBidById($bidId);

        if (!$bid || !$auctionId->equals($bid->auction()->id())) {
            throw new BidNotInAuctionException($auctionId, $bidId);
        }

        if (!$auction->isOpen() || $auction->winningBid()) {
            throw new InvalidAuctionStatusException($auctionId);
        }

        $auction->close($bid, $command->closedAt());
        $this->auctionRepository->update($auction);

        $this->eventBus->publish(...$auction->pullEvents());
    }
}
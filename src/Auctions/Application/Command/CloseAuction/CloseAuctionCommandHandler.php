<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CloseAuction;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\Contract\AuctionRepository;
use App\Auctions\Domain\Contract\BidRepository;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Auctions\Domain\DomainService\FindBidById;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\InvalidAuctionStatusException;
use App\Auctions\Domain\Exception\InvalidBidException;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;

final class CloseAuctionCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FindAuctionById $findAuctionById,
        private readonly FindBidById $findBidById,
        private readonly BidRepository $bidRepository,
        private readonly AuctionRepository $auctionRepository
    ) {}

    public function __invoke(CloseAuctionCommand $command): void
    {
        $auction = $this->findAuctionById->__invoke(
            Uuid::fromString($command->id())
        );

        if (!$auction->user()->id()->equals(Uuid::fromString($command->userId()))) {
            throw new AuctionNotFoundException();
        }

        $bid = $this->findBidById->__invoke(
            Uuid::fromString($command->bidId())
        );

        if ($auction->id() !== $bid->auction()->id()) {
            throw new InvalidBidException('Bid doesnt belong to auction');
        }

        if (!$auction->isOpen() || $auction->winningBid()) {
            throw new InvalidAuctionStatusException();
        }

        $auction->updateStatus(Auction::STATUS_CLOSED);
        $auction->updateUpdatedAt($command->closedAt());
        $bid->updateIsWinner(true);
        $bid->updateUpdatedAt($command->closedAt());

        $this->auctionRepository->update($auction);
        $this->bidRepository->update($bid);
    }
}
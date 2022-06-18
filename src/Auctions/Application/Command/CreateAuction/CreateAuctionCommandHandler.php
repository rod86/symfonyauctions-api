<?php

namespace App\Auctions\Application\Command\CreateAuction;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionRepository;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;

final class CreateAuctionCommandHandler implements CommandHandler
{
    private AuctionRepository $auctionRepository;

    public function __construct(AuctionRepository $auctionRepository)
    {
        $this->auctionRepository = $auctionRepository;    
    }
    
    public function __invoke(CreateAuctionCommand $command): void
    {
        $auction = new Auction(
            Uuid::fromString($command->id()),
            $command->title(),
            $command->description(),
            Auction::STATUS_SCHEDULED,
            $command->startPrice(),
            $command->startDate(),
            $command->finishDate(),
            $command->createdAt(),
            $command->updatedAt()
        );

        $this->auctionRepository->create($auction);
    }
}

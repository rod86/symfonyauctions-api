<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\UpdateAuction;

use App\Auctions\Domain\Contract\AuctionRepository;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;

final class UpdateAuctionCommandHandler implements CommandHandler
{
    public function __construct(
        private FindAuctionById $findAuctionById,
        private AuctionRepository $auctionRepository
    ) {}

    public function __invoke(UpdateAuctionCommand $command): void
    {
        $auction = $this->findAuctionById->__invoke(
            Uuid::fromString($command->id())
        );

        $auction->updateTitle($command->title());
        $auction->updateDescription($command->description());
        $auction->updateInitialAmount($command->initialAmount());
        $auction->updateStatus($command->status());
        $auction->updateUpdatedAt($command->updatedAt());

        $this->auctionRepository->update($auction);
    }
}

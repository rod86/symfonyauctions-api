<?php

declare(strict_types=1);

namespace App\Auctions\Application\Command\CreateAuction;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\Contract\AuctionRepository;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\DomainService\FindUserById;

final class CreateAuctionCommandHandler implements CommandHandler
{
    public function __construct(
        private AuctionRepository $auctionRepository,
        private FindUserById $findUserById
    ) {}
    
    public function __invoke(CreateAuctionCommand $command): void
    {
        $user = $this->findUserById->__invoke(Uuid::fromString($command->userId()));

        $auction = new Auction(
            id: Uuid::fromString($command->id()),
            user: $user,
            title: $command->title(),
            description: $command->description(),
            status: Auction::STATUS_SCHEDULED,
            startPrice: $command->startPrice(),
            startDate: $command->startDate(),
            finishDate: $command->finishDate(),
            createdAt: $command->createdAt(),
            updatedAt: $command->updatedAt()
        );

        $this->auctionRepository->create($auction);
    }
}

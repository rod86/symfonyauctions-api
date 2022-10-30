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
        private readonly AuctionRepository $auctionRepository,
        private readonly FindUserById      $findUserById
    ) {}
    
    public function __invoke(CreateAuctionCommand $command): void
    {
        $user = $this->findUserById->__invoke(Uuid::fromString($command->userId()));

        $auction = new Auction(
            id: Uuid::fromString($command->id()),
            user: $user,
            title: $command->title(),
            description: $command->description(),
            status: $command->status(),
            initialAmount: $command->initialAmount(),
            createdAt: $command->createdAt(),
            updatedAt: $command->updatedAt()
        );

        $this->auctionRepository->create($auction);
    }
}

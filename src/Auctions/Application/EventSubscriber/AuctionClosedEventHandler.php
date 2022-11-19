<?php

declare(strict_types=1);

namespace App\Auctions\Application\EventSubscriber;

use App\Auctions\Domain\Event\AuctionClosedEvent;
use App\Shared\Domain\Bus\Event\EventSubscriber;
use Psr\Log\LoggerInterface;

final class AuctionClosedEventHandler implements EventSubscriber
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}

    public function __invoke(AuctionClosedEvent $event): void
    {
        var_dump($event->toArray());
        $this->logger->info('AuctionClosedEventHandler', $event->toArray());
    }
}
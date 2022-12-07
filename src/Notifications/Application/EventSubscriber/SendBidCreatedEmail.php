<?php

declare(strict_types=1);

namespace App\Notifications\Application\EventSubscriber;

use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Auctions\Domain\DomainService\GetBiddersByAuction;
use App\Auctions\Domain\Event\BidCreatedEvent;
use App\Auctions\Domain\Exception\BidNotInAuctionException;
use App\Notifications\Domain\Contract\NotificationSenderInterface;
use App\Notifications\Domain\Contract\TemplateInterface;
use App\Notifications\Domain\Notification;
use App\Shared\Domain\Bus\Event\EventSubscriber;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;

final class SendBidCreatedEmail implements EventSubscriber
{
    private const SUBJECT = 'Your bid has been outbid';
    private const TEMPLATE = 'email/bid_created.html.twig';

    public function __construct(
        private readonly FindAuctionById $findAuctionById,
        private readonly TemplateInterface $template,
        private readonly GetBiddersByAuction $getBiddersByAuction,
        private readonly NotificationSenderInterface $notificationSender,
        private readonly string $emailFrom
    ) {}

    public function __invoke(BidCreatedEvent $event): void
    {
        $auction = $this->findAuctionById->__invoke(Uuid::fromString($event->aggregateId()));

        $bid = $auction->getBidById(Uuid::fromString($event->bidId()));

        if ($bid === null) {
            throw new BidNotInAuctionException();
        }

        $bidders = $this->getBiddersByAuction->__invoke($auction);

        /** @var User $user */
        foreach ($bidders as $user) {
            $message = $this->template->render(self::TEMPLATE, [
                'user' => $user,
                'auction' => $auction,
                'bid' => $bid
            ]);

            $notification = new Notification(
                $this->emailFrom,
                $user->email(),
                self::SUBJECT,
                $message
            );
            $this->notificationSender->send($notification);
        }
    }
}
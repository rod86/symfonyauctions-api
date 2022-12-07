<?php

declare(strict_types=1);

namespace App\Notifications\Application\EventSubscriber;

use App\Auctions\Domain\AuctionBid;
use App\Auctions\Domain\DomainService\FindAuctionById;
use App\Auctions\Domain\DomainService\GetBiddersByAuction;
use App\Auctions\Domain\Event\AuctionClosedEvent;
use App\Notifications\Domain\Contract\NotificationSenderInterface;
use App\Notifications\Domain\Contract\TemplateInterface;
use App\Notifications\Domain\Notification;
use App\Shared\Domain\Bus\Event\EventSubscriber;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;

final class SendAuctionClosedEmail implements EventSubscriber
{
    private const SUBJECT = 'Auction has been closed';
    private const TEMPLATE = 'email/auction_closed.html.twig';

    private const SUBJECT_WINNER = 'Your bid has been accepted';
    private const TEMPLATE_WINNER = 'email/auction_winner.html.twig';

    public function __construct(
        private readonly FindAuctionById $findAuctionById,
        private readonly TemplateInterface $template,
        private readonly GetBiddersByAuction $getBiddersByAuction,
        private readonly NotificationSenderInterface $notificationSender,
        private readonly string $emailFrom
    ) {}

    public function __invoke(AuctionClosedEvent $event): void
    {
        $auction = $this->findAuctionById->__invoke(Uuid::fromString($event->aggregateId()));

        $bidders = $this->getBiddersByAuction->__invoke($auction);
        /** @var AuctionBid $winningBid */
        $winningBid = $auction->bids()->filter(fn(AuctionBid $bid) => $bid->isWinner() === true)->first();

        // Notify all users
        /** @var User $user */
        foreach ($bidders as $user) {
            $message = $this->template->render(self::TEMPLATE, [
                'user' => $user,
                'auction' => $auction,
                'winning_bid' => $winningBid
            ]);

            $notification = new Notification(
                $this->emailFrom,
                $user->email(),
                self::SUBJECT,
                $message
            );
            $this->notificationSender->send($notification);
        }

        // Notify winner
        $message = $this->template->render(self::TEMPLATE_WINNER, [
            'winning_bid' => $winningBid,
            'auction' => $auction
        ]);
        $notification = new Notification(
            $this->emailFrom,
            $winningBid->user()->email(),
            self::SUBJECT_WINNER,
            $message
        );
        $this->notificationSender->send($notification);
    }
}
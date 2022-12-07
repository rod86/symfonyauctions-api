<?php

declare(strict_types=1);

namespace App\Notifications\Infrastructure\Notification\Mail;

use App\Notifications\Domain\Contract\NotificationSenderInterface;
use App\Notifications\Domain\Notification;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class EmailNotificationSender implements NotificationSenderInterface
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {}

    public function send(Notification $notification): void
    {
        $email = (new Email())
            ->from($notification->from())
            ->to($notification->to())
            ->subject($notification->subject())
            ->html($notification->body());

        $this->mailer->send($email);
    }
}
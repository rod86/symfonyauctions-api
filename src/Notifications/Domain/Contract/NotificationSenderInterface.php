<?php

declare(strict_types=1);

namespace App\Notifications\Domain\Contract;

use App\Notifications\Domain\Notification;

interface NotificationSenderInterface
{
    public function send(Notification $notification): void;
}
<?php

declare(strict_types=1);

namespace App\Notifications\Domain;

final class Notification
{
    public function __construct(
        private readonly string $from,
        private readonly string $to,
        private readonly string $subject,
        private readonly string $body,
    ) {}

    public function from(): string
    {
        return $this->from;
    }

    public function to(): string
    {
        return $this->to;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }
}
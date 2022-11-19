<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event\RabbitMQ;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class RabbitMQEventBus implements EventBus
{
    public function __construct(
        private readonly MessageBusInterface $eventBus
    ) {}

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $routingKeyStamp = new AmqpStamp($event::eventType(), AMQP_NOPARAM, []);

            try {
                $this->eventBus->dispatch($event, [$routingKeyStamp]);
            } catch (NoHandlerForMessageException) {}
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Bus\Exception\CommandNotRegisteredException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class InMemorySymfonyCommandBus implements CommandBus
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {}

    public function dispatch(Command $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (NoHandlerForMessageException $exception) {
            throw new CommandNotRegisteredException($command);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious();
        }
    }
}

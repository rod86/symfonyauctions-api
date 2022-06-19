<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use App\Shared\Infrastructure\Bus\Exception\QueryNotRegisteredException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

class InMemorySymfonyQueryBus implements QueryBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->bus = $queryBus;
    }

    public function ask(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);
            
            return $stamp->getResult();
        } catch (NoHandlerForMessageException $exception) {
            throw new QueryNotRegisteredException($query);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious();
        }
    }
}

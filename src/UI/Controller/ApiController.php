<?php

namespace App\UI\Controller;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use App\UI\Exception\ApiException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

abstract class ApiController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(
        QueryBus $queryBus,
        CommandBus $commandBus
    ) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function throwApiException(int $statusCode, ?string $message = null, \Throwable $previous = null): void
    {
        $message = $message ?? HttpResponse::$statusTexts[$statusCode] ?? ''; 
        
        throw new ApiException($statusCode, $message, $previous);
    }
}

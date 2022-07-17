<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use App\UI\Exception\ApiException;
use App\UI\Security\SecurityUser;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class ApiController
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
        private TokenStorageInterface $tokenStorage,
    ) {}

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

    protected function getUser(): SecurityUser
    {
        $token = $this->tokenStorage->getToken();
    
        return ($token !== null) ? $token->getUser() : null;
    }
}

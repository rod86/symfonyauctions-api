<?php

declare(strict_types=1);

namespace App\UI\Subscriber;

use App\Shared\Domain\DomainException;
use App\Shared\Utils;
use App\UI\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ApiExceptionListener
{
    public function __construct(
        private readonly ExceptionHttpStatusCodeMapper $exceptionHttpStatusCodeMapper
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$event->isMainRequest()) {
            return;
        }

        $response = $this->buildResponse($exception);
        $event->setResponse($response);
    }

    private function buildResponse(\Throwable $exception): JsonResponse
    {
        $content = [
            'code' => $this->getErrorCode($exception),
            'error' => $exception->getMessage(),
        ];

        if ($exception instanceof ValidationException) {
            $content['errors'] = $exception->getErrors();
        }

        return new JsonResponse($content, $this->getStatusCode($exception));
    }

    private function getStatusCode(\Throwable $exception): int
    {
        $statusCode = $this->exceptionHttpStatusCodeMapper->getStatusCodeFor($exception::class);

        if ($statusCode === null && $exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
        }

        return $statusCode ?? Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function getErrorCode(\Throwable $exception): string
    {
        return $exception instanceof DomainException
            ? $exception->errorCode()
            : Utils::toSnakeCase(Utils::extractClassName($exception::class));
    }
}
<?php

declare(strict_types=1);

namespace App\UI\Subscriber;

use App\UI\Exception\ApiException;
use App\UI\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionHandlerSubscriber
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$event->isMainRequest()) {
            return;
        }

        if (!$exception instanceof ApiException) {
            return;
        }
        
        $response = $this->buildResponse($exception);
        $event->setResponse($response);
    }

    private function buildResponse(ApiException $exception): JsonResponse
    {
        $content = [
            'message' => $exception->getMessage() !== '' ?
                $exception->getMessage() : 'An API error occurred',
        ];

        if ($exception instanceof ValidationException) {
            $content['errors'] = $exception->getErrors();
        }
        
        $statusCode = $exception->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;

        return new JsonResponse($content, $statusCode);
    }
}
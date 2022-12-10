<?php

declare(strict_types=1);

namespace App\UI\Subscriber;

use App\Auctions\Domain\Exception\AuctioneerCannotBidException;
use App\Auctions\Domain\Exception\AuctionNotAcceptBidsException;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\BidNotInAuctionException;
use App\Auctions\Domain\Exception\InvalidAuctionStatusException;
use App\Auctions\Domain\Exception\InvalidBidAmountException;
use App\Auctions\Domain\Exception\UserOutbidHimselfException;
use App\Shared\Domain\DomainException;
use App\Shared\Utils;
use App\UI\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ApiExceptionListener
{
    private const EXCEPTIONS = [
        // Auctions
        AuctioneerCannotBidException::class => Response::HTTP_PRECONDITION_FAILED,
        AuctionNotAcceptBidsException::class => Response::HTTP_PRECONDITION_FAILED,
        AuctionNotFoundException::class => Response::HTTP_NOT_FOUND,
        BidNotInAuctionException::class => Response::HTTP_NOT_FOUND,
        InvalidAuctionStatusException::class => Response::HTTP_PRECONDITION_FAILED,
        InvalidBidAmountException::class => Response::HTTP_PRECONDITION_FAILED,
        UserOutbidHimselfException::class => Response::HTTP_PRECONDITION_FAILED
    ];

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
        if ($exception instanceof DomainException) {
            $statusCode = self::EXCEPTIONS[$exception::class] ?? null;
        } elseif ($exception instanceof HttpException) {
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
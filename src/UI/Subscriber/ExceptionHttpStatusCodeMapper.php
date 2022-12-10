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
use App\Users\Domain\Exception\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response;

final class ExceptionHttpStatusCodeMapper
{
    private const EXCEPTIONS = [
        // User
        UserAlreadyExistsException::class => Response::HTTP_PRECONDITION_FAILED,

        // Auctions
        AuctioneerCannotBidException::class => Response::HTTP_PRECONDITION_FAILED,
        AuctionNotAcceptBidsException::class => Response::HTTP_PRECONDITION_FAILED,
        AuctionNotFoundException::class => Response::HTTP_NOT_FOUND,
        BidNotInAuctionException::class => Response::HTTP_NOT_FOUND,
        InvalidAuctionStatusException::class => Response::HTTP_PRECONDITION_FAILED,
        InvalidBidAmountException::class => Response::HTTP_PRECONDITION_FAILED,
        UserOutbidHimselfException::class => Response::HTTP_PRECONDITION_FAILED
    ];

    public function getStatusCodeFor(string $exceptionClass): ?int
    {
        return self::EXCEPTIONS[$exceptionClass] ?? null;
    }
}
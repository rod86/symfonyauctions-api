<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use App\Auctions\Application\Command\CloseAuction\CloseAuctionCommand;
use App\Auctions\Domain\Exception\BidNotInAuctionException;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\InvalidAuctionStatusException;
use App\Auctions\Domain\Exception\InvalidBidException;
use App\UI\Controller\ApiController;
use App\UI\Request\CloseAuctionRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CloseAuctionController extends ApiController
{
    public function __invoke(string $id, CloseAuctionRequest $request): Response
    {
        $data = $request->payload();
        $userId = $this->getUser()->getId();

        try {
            $this->dispatch(new CloseAuctionCommand(
                id: $id,
                bidId: $data['bid_id'],
                userId: $userId,
                closedAt: new \DateTimeImmutable()
            ));
        } catch (AuctionNotFoundException $exception) {
            $this->throwApiException(
                Response::HTTP_NOT_FOUND,
                sprintf(
                    'Auction with id "%s" not found',
                    $id
                ),
                $exception
            );
        } catch (BidNotInAuctionException $exception) {
            $this->throwApiException(
                Response::HTTP_NOT_FOUND,
                sprintf(
                    'Bid with id "%s" not found',
                    $data['bid_id']
                ),
                $exception
            );
        } catch (InvalidBidException $exception) {
            $this->throwApiException(
                Response::HTTP_PRECONDITION_FAILED,
                'Invalid bid',
                $exception
            );
        } catch (InvalidAuctionStatusException $exception) {
            $this->throwApiException(
                Response::HTTP_PRECONDITION_FAILED,
                'Auction cannot be closed',
                $exception
            );
        }

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use DateTimeImmutable;
use App\UI\Controller\ApiController;
use App\UI\Request\CreateBidRequest;
use App\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Auctions\Application\Command\CreateBid\CreateBidCommand;
use App\Auctions\Domain\Exception\AuctionNotAcceptBidsException;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\Auctions\Domain\Exception\InvalidBidException;

final class CreateBidController extends ApiController
{
    public function __invoke(CreateBidRequest $request): Response
    {
        $data = $request->payload();

        $userId = $this->getUser()->getId();

        try {
            $this->dispatch(new CreateBidCommand(
                id: Uuid::random()->value(),
                auctionId: $data['auction_id'],
                userId: $userId,
                amount: $data['amount'],
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable(),
            ));
        } catch (AuctionNotFoundException $exception) {
            $this->throwApiException(
                Response::HTTP_NOT_FOUND,
                sprintf(
                    'Auction with id "%s" not found',
                    $data['auction_id']
                ),
                $exception 
            );
        } catch (AuctionNotAcceptBidsException|InvalidBidException $exception) {
            $this->throwApiException(
                Response::HTTP_PRECONDITION_FAILED,
                $exception->getMessage()
            );
        } catch (\Exception $exception) {
            $this->throwApiException(
                Response::HTTP_INTERNAL_SERVER_ERROR, 
                'An error ocurred while creating the bid',
                $exception
            );
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

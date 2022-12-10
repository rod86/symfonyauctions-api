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

final class CreateBidController extends ApiController
{
    public function __invoke(CreateBidRequest $request): Response
    {
        $data = $request->payload();

        $userId = $this->getUser()->getId();

        $this->dispatch(new CreateBidCommand(
            id: Uuid::random()->value(),
            userId: $userId,
            auctionId: $data['auction_id'],
            amount: $data['amount'],
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable(),
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

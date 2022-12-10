<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use App\Auctions\Application\Command\CloseAuction\CloseAuctionCommand;
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

        $this->dispatch(new CloseAuctionCommand(
            id: $id,
            bidId: $data['bid_id'],
            userId: $userId,
            closedAt: new \DateTimeImmutable()
        ));

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
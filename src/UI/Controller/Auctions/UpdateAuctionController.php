<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use DateTimeImmutable;
use App\UI\Controller\ApiController;
use App\UI\Request\CreateAuctionRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Auctions\Application\Command\UpdateAuction\UpdateAuctionCommand;

final class UpdateAuctionController extends ApiController
{
    public function __invoke(string $id, CreateAuctionRequest $request): Response
    {
        $data = $request->payload();
        $userId = $this->getUser()->getId();

        $this->dispatch(new UpdateAuctionCommand(
            id: $id,
            title: $data['title'],
            description: $data['description'],
            initialAmount: (float)$data['initial_amount'],
            status: $data['status'],
            userId: $userId,
            updatedAt: new DateTimeImmutable(),
        ));

        return new JsonResponse(null, Response::HTTP_OK);
    }
}

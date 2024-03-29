<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use DateTimeImmutable;
use App\Shared\Domain\ValueObject\Uuid;
use App\UI\Request\CreateAuctionRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Auctions\Application\Command\CreateAuction\CreateAuctionCommand;
use App\UI\Controller\ApiController;

final class CreateAuctionController extends ApiController
{
    public function __invoke(CreateAuctionRequest $request): Response
    {
        $data = $request->payload();

        $id = Uuid::random()->value();
        $userId = $this->getUser()->getId();

        $this->dispatch(new CreateAuctionCommand(
            id: $id,
            userId: $userId,
            title: $data['title'],
            description: $data['description'],
            initialAmount: (float)$data['initial_amount'],
            status: $data['status'],
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable(),
        ));
        
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

<?php

namespace App\UI\Controller\Auctions;

use App\Shared\Utils;
use DateTimeImmutable;
use App\Shared\Domain\ValueObject\Uuid;
use App\UI\Request\CreateAuctionRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Auctions\Application\Command\CreateAuction\CreateAuctionCommand;
use App\Auctions\Application\Command\CreateAuction\CreateAuctionCommandHandler;

class CreateAuctionController
{
    private CreateAuctionCommandHandler $createAuctionCommandHandler;

    public function __construct(
        CreateAuctionCommandHandler $createAuctionCommandHandler
    ) {
        $this->createAuctionCommandHandler = $createAuctionCommandHandler;
    }

    public function __invoke(CreateAuctionRequest $request): Response
    {
        $data = $request->payload();

        $id = Uuid::random()->value();

        $this->createAuctionCommandHandler->__invoke(new CreateAuctionCommand(
            $id,
            $data['title'],
            $data['description'],
            (float)$data['start_price'],
            Utils::stringToDate($data['start_date']),
            Utils::stringToDate($data['finish_date']),
            new DateTimeImmutable(),
            new DateTimeImmutable(),
        ));
        
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

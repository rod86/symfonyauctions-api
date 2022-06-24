<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use App\Shared\Utils;
use DateTimeImmutable;
use App\UI\Controller\ApiController;
use App\UI\Request\CreateAuctionRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Auctions\Application\Command\UpdateAuction\UpdateAuctionCommand;

class UpdateAuctionController extends ApiController
{
    public function __invoke(string $id, CreateAuctionRequest $request): Response
    {
        $data = $request->payload();
        
        $this->dispatch(new UpdateAuctionCommand(
            id: $id,
            title: $data['title'],
            description: $data['description'],
            startPrice: (float)$data['start_price'],
            startDate: Utils::stringToDate($data['start_date']),
            finishDate: Utils::stringToDate($data['finish_date']),
            updatedAt: new DateTimeImmutable(),
        ));

        return new JsonResponse(null, Response::HTTP_OK);
    }
}

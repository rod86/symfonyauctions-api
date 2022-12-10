<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQuery;
use App\UI\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetAuctionByIdController extends ApiController
{
    public function __invoke(string $id): Response
    {
        $response = $this->ask(new FindAuctionByIdQuery($id));

        return new JsonResponse($response->data(), Response::HTTP_OK);
    }
}

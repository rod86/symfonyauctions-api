<?php

namespace App\UI\Controller\Auctions;

use App\Auctions\Application\Query\FindAuctions\FindAuctionsQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\UI\Controller\ApiController;

class GetAuctionsController extends ApiController
{
    public function __invoke(): Response
    {
        $response = $this->ask(new FindAuctionsQuery);

        return new JsonResponse($response->data(), Response::HTTP_OK);
    }
}

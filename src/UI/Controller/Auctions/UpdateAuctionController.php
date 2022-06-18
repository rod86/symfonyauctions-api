<?php

namespace App\UI\Controller\Auctions;

use App\UI\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateAuctionController extends ApiController
{
    public function __invoke(string $id): Response
    {
        return new JsonResponse(["UPDATING $id"], Response::HTTP_OK);
    }
}

<?php

declare(strict_types=1);

namespace App\UI\Controller\Auctions;

use App\Auctions\Application\Query\FindAuctionById\FindAuctionByIdQuery;
use App\Auctions\Domain\Exception\AuctionNotFoundException;
use App\UI\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAuctionByIdController extends ApiController
{
    public function __invoke(string $id)
    {
        try {
            $response = $this->ask(new FindAuctionByIdQuery($id));
        } catch (AuctionNotFoundException $exception) {
            $this->throwApiException(
                Response::HTTP_NOT_FOUND,
                sprintf(
                    'Auction with id "%s" not found',
                    $id
                ),
                $exception 
            );
        }

        return new JsonResponse($response->data(), Response::HTTP_OK);
    }
}

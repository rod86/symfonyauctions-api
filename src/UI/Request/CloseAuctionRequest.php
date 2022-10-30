<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CloseAuctionRequest extends AbstractRequest
{
    protected function validationRules(): Assert\Collection
    {
        return new Assert\Collection([
            'bid_id' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ],
        ]);
    }
}
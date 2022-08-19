<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateBidRequest extends AbstractRequest
{
    protected function validationRules(): Assert\Collection
    {
        return new Assert\Collection([
            'auction_id' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ],
            'amount' => [
                new Assert\NotBlank(),
                new Assert\Type('numeric'),
            ],
        ]);
    }
}

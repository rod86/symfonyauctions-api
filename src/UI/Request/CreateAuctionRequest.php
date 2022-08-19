<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateAuctionRequest extends AbstractRequest
{
    protected function validationRules(): Assert\Collection
    {
        return new Assert\Collection([
            'title' => new Assert\NotBlank(),
            'description' => [
                new Assert\NotBlank()
            ],
            'initial_amount' => [
                new Assert\NotBlank(),
                new Assert\Type('numeric'),
            ],
        ]);
    }
}

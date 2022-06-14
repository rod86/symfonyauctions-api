<?php

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
            'start_price' => [
                new Assert\NotBlank(),
                new Assert\Type('numeric'),
            ],
            'start_date' => [
                new Assert\NotBlank(),
                new Assert\DateTime(),
            ],
            'finish_date' => [
                new Assert\NotBlank(),
                new Assert\DateTime(),
            ]
        ]);
    }
}

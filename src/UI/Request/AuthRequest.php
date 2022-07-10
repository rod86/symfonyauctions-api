<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

class AuthRequest extends AbstractRequest
{
    protected function validationRules(): Assert\Collection
    {
        return new Assert\Collection([
            'username' => [
                new Assert\NotBlank()
            ],
            'password' => [
                new Assert\NotBlank(),
            ],
        ]);
    }
}

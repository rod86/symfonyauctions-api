<?php

declare(strict_types=1);

namespace App\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SignUpRequest extends AbstractRequest
{
    protected function validationRules(): Assert\Collection
    {
        return new Assert\Collection([
            'username' => [
                new Assert\NotBlank()
            ],
            'email' => [
                new Assert\NotBlank(),
                new Assert\Email(),
            ],
            'password' => [
                new Assert\NotBlank(),
                new Assert\Length(min: 6),
            ],
            'password_confirm' => [
                new Assert\NotBlank(),
                new Assert\Callback(callback: [$this, 'validatePasswordConfirm']),
            ],
        ]);
    }

    public function validatePasswordConfirm($value, ExecutionContextInterface $context): void
    {
        if ( $value !== $context->getRoot()['password'] ) {
            $context->addViolation('Passwords do not match');
        }
    }
}

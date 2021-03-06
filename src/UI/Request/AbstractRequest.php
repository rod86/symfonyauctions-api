<?php

declare(strict_types=1);

namespace App\UI\Request;

use App\UI\Validation\Validator;
use App\UI\Exception\ValidationException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractRequest
{
    final public function __construct(
        private Validator $validator,
        protected RequestStack $request
    ) {
        $this->validate();
    }

    final protected function validate(): void
    {
        $errors = $this->validator->validate($this->payload(), $this->validationRules());
        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }

    public function payload(): array
    {
        return json_decode($this->request->getCurrentRequest()->getContent(), true) ?? [];
    }

    abstract protected function validationRules(): Assert\Collection;
}

<?php

declare(strict_types=1);

namespace App\UI\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends ApiException
{
    private array $errors = [];

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct(
            Response::HTTP_PRECONDITION_FAILED,
            'Invalid request data.',
        );
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

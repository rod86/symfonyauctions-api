<?php

namespace App\UI\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends ApiException
{
    private $errors = [];

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

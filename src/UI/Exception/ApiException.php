<?php

namespace App\UI\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    public function __construct(
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        string $message = '',
        \Throwable $previous = null
    ) {
        parent::__construct($statusCode, $message, $previous);
    }
}

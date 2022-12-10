<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use App\Shared\Domain\DomainException;

class InvalidPasswordException extends DomainException
{
    public function errorCode(): string
    {
        return 'invalid_password';
    }

    public function errorMessage(): string
    {
        return 'Invalid password.';
    }
}
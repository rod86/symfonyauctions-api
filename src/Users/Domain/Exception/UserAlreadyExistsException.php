<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use App\Shared\Domain\DomainException;

class UserAlreadyExistsException extends DomainException
{
    public function errorCode(): string
    {
        return 'user_exists';
    }

    public function errorMessage(): string
    {
        return 'User with this username and/or email already exists.';
    }
}
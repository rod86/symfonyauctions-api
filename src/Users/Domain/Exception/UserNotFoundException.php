<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use App\Shared\Domain\DomainException;

class UserNotFoundException extends DomainException
{
    public function errorCode(): string
    {
        return 'user_not_found';
    }

    public function errorMessage(): string
    {
        return 'User not found.';
    }
}
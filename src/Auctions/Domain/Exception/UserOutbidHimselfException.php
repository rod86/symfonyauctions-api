<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

use App\Shared\Domain\DomainException;

final class UserOutbidHimselfException extends DomainException
{
    public function errorCode(): string
    {
        return 'user_outbid_himself';
    }

    public function errorMessage(): string
    {
        return 'User cannot outbid himself';
    }
}
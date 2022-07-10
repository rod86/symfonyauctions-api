<?php

declare(strict_types=1);

namespace App\Users\Application\Query\Authenticate;

use App\Shared\Domain\Bus\Query\Response;

class AuthenticateResponse implements Response
{
    public function __construct(
        private array $data
    ) {}

    public function data(): array
    {
        return $this->data;
    }
}

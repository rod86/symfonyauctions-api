<?php

declare(strict_types=1);

namespace App\Users\Domain\Contract;

interface ApiTokenEncoder
{
    public function encode(array $payload): string;

    public function decode(string $token): array;
}

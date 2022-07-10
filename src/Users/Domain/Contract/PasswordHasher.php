<?php

declare(strict_types=1);

namespace App\Users\Domain\Contract;

interface PasswordHasher
{
    public function hash(string $plainPassword): string;

    public function verify(string $hashedPassword, string $plainPassword): bool;
}

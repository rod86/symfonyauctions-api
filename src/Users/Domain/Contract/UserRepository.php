<?php

declare(strict_types=1);

namespace App\Users\Domain\Contract;

use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;

interface UserRepository
{
    public function create(User $user): void;

    public function findUserByUsernameOrEmail(string $username, string $email): User|null;

    public function findById(Uuid $id): User|null;
}

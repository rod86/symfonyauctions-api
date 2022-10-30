<?php

declare(strict_types=1);

namespace App\Users\Domain\DomainService;

use App\Users\Domain\User;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\Contract\UserRepository;
use App\Users\Domain\Exception\UserNotFoundException;

final class FindUserById
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(Uuid $id): User
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

<?php

declare(strict_types=1);

namespace App\Users\Application\Command\SignUp;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\Contract\PasswordHasher;
use App\Users\Domain\Contract\UserRepository;
use App\Users\Domain\Exception\UserAlreadyExistsException;
use App\Users\Domain\User;

class SignUpCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
    ) {}

    public function __invoke(SignUpCommand $command): void
    {
        $existingUser = $this->userRepository->findUserByUsernameOrEmail(
            username: $command->username(),
            email: $command->email()
        );

        if ($existingUser !== null) {
            throw new UserAlreadyExistsException();
        }

        $hashedPassword = $this->passwordHasher->hash($command->plainPassword());

        $user = new User(
            id: Uuid::fromString($command->id()),
            username: $command->username(),
            email: $command->email(),
            password: $hashedPassword,
            createdAt: $command->createdAt(),
            updatedAt: $command->updatedAt(),
        );

        $this->userRepository->create($user);
    }
}
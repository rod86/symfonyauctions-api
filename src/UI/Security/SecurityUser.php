<?php

declare(strict_types=1);

namespace App\UI\Security;

use App\Users\Domain\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    public function __construct(
        private string $id,
        private string $userIdentifier,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }

    public static function fromUser(User $user): self 
    {
        return new self(
            id: $user->id()->value(),
            userIdentifier: $user->username(),
        );
    }
}
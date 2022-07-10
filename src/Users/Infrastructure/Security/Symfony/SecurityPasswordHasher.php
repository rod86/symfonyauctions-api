<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security\Symfony;

use App\UI\Security\SecurityUser;
use App\Users\Domain\Contract\PasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class SecurityPasswordHasher implements PasswordHasher
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory   
    ) {}

    public function hash(string $plainPassword): string
    {
        return $this->passwordHasher()->hash($plainPassword);
    }

    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $this->passwordHasher()->verify($hashedPassword, $plainPassword);
    }

    private function passwordHasher(): PasswordHasherInterface
    {
        return $this->passwordHasherFactory->getPasswordHasher(SecurityUser::class);
    }
}

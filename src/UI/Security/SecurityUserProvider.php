<?php

declare(strict_types=1);

namespace App\UI\Security;

use App\Users\Domain\Contract\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SecurityUserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function supportsClass(string $class): bool
    {
        return $class === SecurityUser::class;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityUser) {
            throw new UnsupportedUserException(
                sprintf('Invalid user class "%s"', $user::class)
            );
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    /**
     * Loads the user for the given user identifier (e.g. username or email).
     *
     * This method must throw UserNotFoundException if the user is not found.
     *
     * @throws UserNotFoundException
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $userEntity = $this->userRepository->findUserByUsernameOrEmail(
            username: $identifier,
            email: $identifier,
        );

        if (!$userEntity) {
            throw new UserNotFoundException(sprintf(
                'No user found for "%s"',
                $identifier,
            ));
        }

        return SecurityUser::fromUser($userEntity);
    }
}

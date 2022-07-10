<?php

declare(strict_types=1);

namespace App\Users\Application\Query\Authenticate;

use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Users\Domain\Contract\PasswordHasher;
use App\Users\Domain\Contract\UserRepository;
use App\Users\Domain\Contract\ApiTokenEncoder;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Exception\InvalidPasswordException;
use App\Users\Application\Query\Authenticate\AuthenticateQuery;

class AuthenticateQueryHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
        private ApiTokenEncoder $apiTokenEncoder
    ) {}

    public function __invoke(AuthenticateQuery $query): AuthenticateResponse
    {
        $user = $this->userRepository->findUserByUsernameOrEmail(
            $query->username(),
            $query->username()
        );

        if ($user === null) {
            throw new UserNotFoundException();
        }

        if (!$this->passwordHasher->verify($user->password(), $query->plainPassword())) {
            throw new InvalidPasswordException();
        }

        $token = $this->apiTokenEncoder->encode([
            'id' => $user->id()->value()
        ]);

        return new AuthenticateResponse([
            'token' => $token
        ]);
    }
}

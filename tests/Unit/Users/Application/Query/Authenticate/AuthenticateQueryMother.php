<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Application\Query\Authenticate;

use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Users\Application\Query\Authenticate\AuthenticateQuery;

final class AuthenticateQueryMother
{
    public static function create(
        string $username = null,
        string $plainPassword = null
    ): AuthenticateQuery {
        return new AuthenticateQuery(
            username: $username ?? FakeValueGenerator::username(),
            plainPassword: $plainPassword ?? FakeValueGenerator::plainPassword()
        );
    }
}
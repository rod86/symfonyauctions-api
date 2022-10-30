<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security\ApiTokenEncoder;

use App\Users\Domain\Contract\ApiTokenEncoder;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class FirebaseApiTokenEncoder implements ApiTokenEncoder
{
    private const JWT_ALGORITHM = 'HS256';

    public function __construct(
        private readonly string $jwtSecret,
        private readonly int $expiresIn
    ) {}

    public function encode(array $payload): string
    {
        $payload['exp'] = time() + $this->expiresIn;
        return JWT::encode($payload, $this->jwtSecret, self::JWT_ALGORITHM);
    }

    public function decode(string $token): array
    {
        return (array) JWT::decode(
            $token,
            new Key($this->jwtSecret, self::JWT_ALGORITHM)
        );
    }
}

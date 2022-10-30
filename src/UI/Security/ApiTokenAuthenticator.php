<?php

declare(strict_types=1);

namespace App\UI\Security;

use App\Shared\Domain\ValueObject\Uuid;
use Firebase\JWT\ExpiredException;
use App\Users\Domain\Contract\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\Users\Domain\Contract\ApiTokenEncoder;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly ApiTokenEncoder $apiTokenEncoder,
        private readonly UserRepository $userRepository
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
            $payload = $this->apiTokenEncoder->decode($token);
        } catch (ExpiredException $exception) {
            throw new AuthenticationException('Token expired');
        } catch (\Exception $exception) {
            throw new AuthenticationException("Invalid token");
        }

        return new SelfValidatingPassport(
            new UserBadge(
                $payload['id'],
                function ($userIdentifier) {
                    $user = $this->userRepository->findById(Uuid::fromString($userIdentifier));
                    return SecurityUser::fromUser($user);
                }
            )
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'error' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}

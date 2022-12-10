<?php

declare(strict_types=1);

namespace App\UI\Controller\Users;

use App\Shared\Domain\ValueObject\Uuid;
use App\UI\Controller\ApiController;
use App\UI\Request\SignUpRequest;
use App\Users\Application\Command\SignUp\SignUpCommand;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SignUpController extends ApiController
{
    public function __invoke(SignUpRequest $request): Response
    {
        $data = $request->payload();

        $this->dispatch(new SignUpCommand(
            id: Uuid::random()->value(),
            username: $data['username'],
            email: $data['email'],
            plainPassword: $data['password'],
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

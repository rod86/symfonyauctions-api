<?php

declare(strict_types=1);

namespace App\UI\Controller\Users;

use App\Shared\Domain\ValueObject\Uuid;
use App\UI\Controller\ApiController;
use App\UI\Request\SignUpRequest;
use App\Users\Application\Command\SignUp\SignUpCommand;
use App\Users\Domain\Exception\UserAlreadyExistsException;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SignUpController extends ApiController
{
    public function __invoke(SignUpRequest $request): Response
    {
        $data = $request->payload();

        try {
            $this->dispatch(new SignUpCommand(
                id: Uuid::random()->value(),
                username: $data['username'],
                email: $data['email'],
                plainPassword: $data['password'],
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable()
            ));
        } catch (UserAlreadyExistsException $exception) {
            $this->throwApiException(
                Response::HTTP_PRECONDITION_FAILED,
                'User with this username and/or email already exists.',
                $exception 
            );
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

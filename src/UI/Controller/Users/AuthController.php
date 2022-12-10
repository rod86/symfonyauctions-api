<?php

declare(strict_types=1);

namespace App\UI\Controller\Users;

use App\UI\Controller\ApiController;
use App\UI\Request\AuthRequest;
use App\Users\Application\Query\Authenticate\AuthenticateQuery;
use App\Users\Domain\Exception\InvalidPasswordException;
use App\Users\Domain\Exception\UserNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class AuthController extends ApiController
{
    public function __invoke(AuthRequest $request): Response
    {
        $data = $request->payload();

        try {
            $response = $this->ask(new AuthenticateQuery(
                username: $data['username'],
                plainPassword: $data['password']
            ));
        } catch (UserNotFoundException|InvalidPasswordException $exception) {
            throw new UnauthorizedHttpException(
                challenge: 'Bearer',
                message: 'Invalid username and/or password',
                previous: $exception
            );
        }

        return new JsonResponse($response->data(), Response::HTTP_OK);       
    }
}

<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Response;

it('should create user', function () {
    $body = [
        "username" => "auction_addict",
        "email" => "auction_addict@example.com",
        "password" => "123456",
        "password_confirm" => "123456",
    ];

    $client = $this->getApiClient();
    $response = $client->request('POST', '/users', [
        'json' => $body
    ]);

    expect($response->getStatusCode())->toEqual(Response::HTTP_CREATED);
});

it('should fail if user exists', function () {
    $body = [
        "username" => "rey_subastas",
        "email" => "rey_subastas@example.com",
        "password" => "123456",
        "password_confirm" => "123456",
    ];

    $client = $this->getApiClient();
    $response = $client->request('POST', '/users', [
        'json' => $body
    ]);
    $content = $response->toArray(false);

    expect($response->getStatusCode())->toEqual(Response::HTTP_PRECONDITION_FAILED)
        ->and($content)->toBe([
            "code" => "user_exists",
            "error" => "User with this username and/or email already exists."
        ]);

});

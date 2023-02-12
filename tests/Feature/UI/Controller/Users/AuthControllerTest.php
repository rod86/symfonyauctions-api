<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Response;

it('should return a token', function (string $username, string $password) {
    $body = [
        "username" => $username,
        "password" => $password,
    ];

    $client = $this->getApiClient();
    $response = $client->request('POST', '/auth', [
        'json' => $body
    ]);
    $content = $response->toArray();

    expect($response->getStatusCode())->toEqual(Response::HTTP_OK)
        ->and($content)->toHaveKeys(['token'])
        ->and($content['token'])->toBeString();

})->with([
    'login with username' => ['john_doe', '123456'],
    'login with email' => ['johndoe74@example.com', '123456'],
]);

it('should fail request validation', function () {
    $body = [
        "username" => "",
        "password" => "",
    ];

    $client = $this->getApiClient();
    $response = $client->request('POST', '/auth', [
        'json' => $body
    ]);
    $content = $response->toArray(false);

    expect($response->getStatusCode())->toEqual(Response::HTTP_PRECONDITION_FAILED)
        ->and($content)->toBe([
            "code" => "validation_exception",
            "error" => "Invalid request data.",
            "errors" => [
                "username" => "This value should not be blank.",
                "password" => "This value should not be blank."
            ]
        ]);
});

it('should fail login', function (string $username, string $password) {
    $body = [
        "username" => $username,
        "password" => $password,
    ];

    $client = $this->getApiClient();
    $response = $client->request('POST', '/auth', [
        'json' => $body
    ]);
    $content = $response->toArray(false);

    expect($response->getStatusCode())->toEqual(Response::HTTP_UNAUTHORIZED)
        ->and($content)->toBe([
            'code' => 'unauthorized_http_exception',
            'error' => 'Invalid username and/or password'
        ]);
})->with([
    'invalid username' => ['foo', '123456'],
    'invalid password' => ['john_doe', 'qwerty'],
]);

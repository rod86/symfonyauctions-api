<?php

declare(strict_types=1);

use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Tests\Unit\Users\Application\Query\Authenticate\AuthenticateQueryMother;
use App\Tests\Unit\Users\Domain\UserMother;
use App\Tests\Unit\Users\TestCase\ApiTokenEncoderMock;
use App\Tests\Unit\Users\TestCase\PasswordHasherMock;
use App\Tests\Unit\Users\TestCase\UserRepositoryMock;
use App\Users\Application\Query\Authenticate\AuthenticateQueryHandler;
use App\Users\Application\Query\Authenticate\AuthenticateResponse;
use App\Users\Domain\Exception\InvalidPasswordException;
use App\Users\Domain\Exception\UserNotFoundException;

beforeEach(function () {
    $this->userRepositoryMock = new UserRepositoryMock($this);
    $this->passwordHasherMock = new PasswordHasherMock($this);
    $this->apiTokenEncoderMock = new ApiTokenEncoderMock($this);
});

it('Returns a token', function () {
    $plainPassword = FakeValueGenerator::plainPassword();
    $user = UserMother::create(
        password: FakeValueGenerator::password($plainPassword)
    );

    $query = AuthenticateQueryMother::create($user->username(), $plainPassword);
    $token = FakeValueGenerator::token();
    $response = new AuthenticateResponse([
        'token' => $token
    ]);

    $this->userRepositoryMock->shouldFindUserByUsername($query->username(), $query->username(), $user);
    $this->passwordHasherMock->shouldVerify($user->password(), $plainPassword, true);
    $this->apiTokenEncoderMock->shouldEncode(['id' => $user->id()->value()], $token);

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock->getMock(),
        passwordHasher: $this->passwordHasherMock->getMock(),
        apiTokenEncoder: $this->apiTokenEncoderMock->getMock()
    );

    $result = $handler->__invoke($query);

    expect($result)->toBeQueryResponse($response->data());
});

it('throws error if user not found', function () {
    $plainPassword = FakeValueGenerator::plainPassword();
    $user = UserMother::create(
        password: FakeValueGenerator::password($plainPassword)
    );

    $query = AuthenticateQueryMother::create($user->username(), $plainPassword);

    $this->userRepositoryMock->shouldNotFindUserByUsername($query->username(), $query->username());
    $this->passwordHasherMock->shouldNotCallVerify();

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock->getMock(),
        passwordHasher: $this->passwordHasherMock->getMock(),
        apiTokenEncoder: $this->apiTokenEncoderMock->getMock()
    );

    $handler->__invoke($query);
})->throws(UserNotFoundException::class);

it('throws error if password is invalid', function () {
    $plainPassword = FakeValueGenerator::plainPassword();
    $user = UserMother::create(
        password: FakeValueGenerator::password($plainPassword)
    );

    $query = AuthenticateQueryMother::create($user->username(), $plainPassword);

    $this->userRepositoryMock->shouldFindUserByUsername($query->username(), $query->username(), $user);
    $this->passwordHasherMock->shouldVerifyFail($user->password(), $plainPassword);
    $this->apiTokenEncoderMock->shouldNotCallEncode();

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock->getMock(),
        passwordHasher: $this->passwordHasherMock->getMock(),
        apiTokenEncoder: $this->apiTokenEncoderMock->getMock()
    );

    $handler->__invoke($query);
})->throws(InvalidPasswordException::class);
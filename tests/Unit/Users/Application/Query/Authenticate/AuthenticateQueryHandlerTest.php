<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Application\Query\Authenticate;

use App\UI\Fixture\Factory\UserFactory;
use App\Users\Application\Query\Authenticate\AuthenticateQuery;
use App\Users\Application\Query\Authenticate\AuthenticateQueryHandler;
use App\Users\Application\Query\Authenticate\AuthenticateResponse;
use App\Users\Domain\Contract\ApiTokenEncoder;
use App\Users\Domain\Contract\PasswordHasher;
use App\Users\Domain\Contract\UserRepository;
use App\Users\Domain\Exception\InvalidPasswordException;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\User;

beforeEach(function () {
    $this->userRepositoryMock = $this->getMockBuilder(UserRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

    $this->passwordHasherMock = $this->getMockBuilder(PasswordHasher::class)
        ->disableOriginalConstructor()
        ->getMock();

    $this->apiTokenEncoderMock = $this->getMockBuilder(ApiTokenEncoder::class)
        ->disableOriginalConstructor()
        ->getMock();
});

it('Returns a token', function () {
    /** @var User $user */
    $user = UserFactory::new()->createOne();
    $plainPassword = '123456';
    $jwtToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
    $response = new AuthenticateResponse([
        'token' => $jwtToken
    ]);

    $this->userRepositoryMock
        ->expects($this->once())
        ->method('findUserByUsernameOrEmail')
        ->with($user->username(), $user->username())
        ->willReturn($user);

    $this->passwordHasherMock
        ->expects($this->once())
        ->method('verify')
        ->with($user->password(), $plainPassword)
        ->willReturn(true);

    $this->apiTokenEncoderMock
        ->expects($this->once())
        ->method('encode')
        ->with(['id' => $user->id()->value()])
        ->willReturn($jwtToken);

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock,
        passwordHasher: $this->passwordHasherMock,
        apiTokenEncoder: $this->apiTokenEncoderMock
    );

    $result = $handler->__invoke(new AuthenticateQuery(
        username: $user->username(),
        plainPassword: $plainPassword
    ));

    expect($result)->toEqual($response);
});

it('throws error if user not found', function () {
    /** @var User $user */
    $user = UserFactory::new()->createOne();
    $plainPassword = '123456';

    $this->userRepositoryMock
        ->expects($this->once())
        ->method('findUserByUsernameOrEmail')
        ->with($user->username(), $user->username())
        ->willReturn(null);

    $this->passwordHasherMock
        ->expects($this->never())
        ->method('verify');

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock,
        passwordHasher: $this->passwordHasherMock,
        apiTokenEncoder: $this->apiTokenEncoderMock
    );

    $handler->__invoke(new AuthenticateQuery(
        username: $user->username(),
        plainPassword: $plainPassword
    ));
})->throws(UserNotFoundException::class);

it('throws error if password is invalid', function () {
    /** @var User $user */
    $user = UserFactory::new()->createOne();
    $plainPassword = '123456';

    $this->userRepositoryMock
        ->expects($this->once())
        ->method('findUserByUsernameOrEmail')
        ->with($user->username(), $user->username())
        ->willReturn($user);

    $this->passwordHasherMock
        ->expects($this->once())
        ->method('verify')
        ->with($user->password(), $plainPassword)
        ->willReturn(false);

    $this->apiTokenEncoderMock
        ->expects($this->never())
        ->method('encode');

    $handler = new AuthenticateQueryHandler(
        userRepository: $this->userRepositoryMock,
        passwordHasher: $this->passwordHasherMock,
        apiTokenEncoder: $this->apiTokenEncoderMock
    );

    $handler->__invoke(new AuthenticateQuery(
        username: $user->username(),
        plainPassword: $plainPassword
    ));
})->throws(InvalidPasswordException::class);
<?php

declare(strict_types=1);

use App\Tests\Unit\Users\Domain\UserMother;
use App\Tests\Unit\Users\TestCase\UserRepositoryMock;
use App\Users\Domain\DomainService\FindUserById;
use App\Users\Domain\Exception\UserNotFoundException;

beforeEach(function () {
    $this->userRepositoryMock = new UserRepositoryMock($this);
});

it('return user', function () {
    $user = UserMother::create();

    $this->userRepositoryMock->shouldFindUserById($user->id(), $user);

    $service = new FindUserById(
        userRepository: $this->userRepositoryMock->getMock()
    );
    $result = $service->__invoke($user->id());

    expect($result)->toEqual($user);
});

it('throws error if user not found',  function () {
    $user = UserMother::create();

    $this->userRepositoryMock->shouldNotFindUserById($user->id());

    $service = new FindUserById(
        userRepository: $this->userRepositoryMock->getMock()
    );
    $result = $service->__invoke($user->id());

    expect($result)->toEqual($user);
})->throws(UserNotFoundException::class);
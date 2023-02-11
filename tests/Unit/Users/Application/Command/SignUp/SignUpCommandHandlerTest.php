<?php

declare(strict_types=1);

use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Tests\Unit\Users\Application\Command\SignUp\SignUpCommandMother;
use App\Tests\Unit\Users\Domain\UserMother;
use App\Tests\Unit\Users\TestCase\PasswordHasherMock;
use App\Tests\Unit\Users\TestCase\UserRepositoryMock;
use App\Users\Application\Command\SignUp\SignUpCommandHandler;
use App\Users\Domain\Exception\UserAlreadyExistsException;

beforeEach(function (){
    $this->userRepositoryMock = new UserRepositoryMock($this);
    $this->passwordHasherMock = new PasswordHasherMock($this);
});

it( 'creates user', function () {
    $plainPassword = FakeValueGenerator::plainPassword();
    $user = UserMother::create(
        password: FakeValueGenerator::password($plainPassword)
    );

    $command = SignUpCommandMother::createFromUser($user, $plainPassword);

    $this->userRepositoryMock->shouldNotFindUserByUsername($command->username(), $command->email());
    $this->passwordHasherMock->shouldHash($plainPassword, $user->password());
    $this->userRepositoryMock->shouldCreate($user);

    $handler = new SignUpCommandHandler(
        userRepository: $this->userRepositoryMock->getMock(),
        passwordHasher: $this->passwordHasherMock->getMock()
    );
    $handler->__invoke($command);
});

it('throws error if user exists', function () {
    $plainPassword = FakeValueGenerator::plainPassword();
    $user = UserMother::create(
        password: FakeValueGenerator::password($plainPassword)
    );

    $command = SignUpCommandMother::createFromUser($user, $plainPassword);

    $this->userRepositoryMock->shouldFindUserByUsername($command->username(), $command->email(), $user);
    $this->passwordHasherMock->shouldNotCallHash();

    $handler = new SignUpCommandHandler(
        userRepository: $this->userRepositoryMock->getMock(),
        passwordHasher: $this->passwordHasherMock->getMock()
    );
    $handler->__invoke($command);
})->throws(UserAlreadyExistsException::class);
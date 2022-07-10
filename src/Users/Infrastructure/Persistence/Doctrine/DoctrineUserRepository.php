<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Persistence\Doctrine;

use App\Users\Domain\User;
use Doctrine\ORM\Query\Parameter;
use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\Contract\UserRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    protected function entityClass(): string
    {
        return User::class;
    }

    public function create(User $user): void
    {
        $this->persist($user);
    }

    public function findUserByUsernameOrEmail(string $username, string $email): User|null
    {        
        return $this->repository()->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findById(Uuid $id): User|null
    {
        return $this->repository()->findOneBy(['id' => $id->value()]);
    }
}

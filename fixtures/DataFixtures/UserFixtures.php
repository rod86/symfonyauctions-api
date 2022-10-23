<?php

declare(strict_types=1);

namespace App\Fixtures\DataFixtures;

use App\Fixtures\Factory\UserFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

final class UserFixtures extends Fixture
{
    private const NUM_USERS = 10;

    private const DATA = [
        'johndoe' => ['username' => 'john_doe', 'email' => 'johndoe74@example.com'],
        'reysubastas' => ['username' => 'rey_subastas', 'email' => 'rey_subastas@example.com'],
        'foobaz' => ['username' => 'foobaz2000', 'email' => 'fbaz@example.com']
    ];

    public function load(ObjectManager $manager): void
    {
        // Add users with defined data
        $userFactory = UserFactory::new();

        foreach (self::DATA as $key => $userData) {
            $user = $userFactory->createOne($userData);
            $this->addReference('user:'.$key, $user);
            $manager->persist($user);
        }

        // Add random users
        $users = $userFactory->createMany(number: self::NUM_USERS);

        foreach ($users as $key => $user) {
            $this->addReference('user:'. $key, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
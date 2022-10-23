<?php

declare(strict_types=1);

namespace App\Fixtures\DataFixtures;

use App\Auctions\Domain\Auction;
use App\Fixtures\Factory\AuctionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AuctionFixtures extends Fixture implements DependentFixtureInterface
{
    private const DATA = [
        'victorian_clock' => [
            'user' => 'user:johndoe',
            'title' => 'Victorian Clock',
            'status' => Auction::STATUS_DRAFT,
        ],
        'french_glasses' => [
            'user' => 'user:johndoe',
            'title' => 'Old French Glasses',
            'status' => Auction::STATUS_ENABLED,
        ],
        'ford_car' => [
            'user' => 'user:johndoe',
            'title' => '1900 Ford car',
            'status' => Auction::STATUS_ENABLED,
        ],
        'helmet' => [
            'user' => 'user:johndoe',
            'title' => 'Middle Age Armour Helmet',
            'status' => Auction::STATUS_CLOSED
        ],
        'mario' => [
            'user' => 'user:foobaz',
            'title' => 'Super Mario Bros (Sealed)',
            'status' => Auction::STATUS_DRAFT
        ],
        'nes' => [
            'user' => 'user:foobaz',
            'title' => 'Refurbished NES',
            'status' => Auction::STATUS_ENABLED
        ],
        'darth_vader' => [
            'user' => 'user:foobaz',
            'title' => '1980s Darth Vader Toy (New)',
            'status' => Auction::STATUS_CLOSED
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $auctionFactory = AuctionFactory::new();

        foreach (self::DATA as $key => $item) {
            $auctionAttributes = $this->buildAttributesFromItemData($item);
            $auction = $auctionFactory->createOne($auctionAttributes);
            $this->addReference('auction:' . $key, $auction);
            $manager->persist($auction);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }

    private function buildAttributesFromItemData(array $item): array
    {
        if (isset($item['user'])) {
            $item['user'] = $this->getReference($item['user']);
        }

        return $item;
    }
}
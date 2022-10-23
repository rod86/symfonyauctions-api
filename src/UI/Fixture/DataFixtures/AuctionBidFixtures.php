<?php

declare(strict_types=1);

namespace App\UI\Fixture\DataFixtures;

use App\Auctions\Domain\Auction;
use App\Auctions\Domain\AuctionBid;
use App\UI\Fixture\Factory\AuctionBidFactory;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AuctionBidFixtures extends Fixture implements DependentFixtureInterface
{
    private const DATA = [
        [
            'auction' => 'auction:ford_car',
            'bidders' => [
                'user:0',
                'user:reysubastas',
                'user:1',
                'user:reysubastas'
            ]
        ],
        [
            'auction' => 'auction:helmet',
            'bidders' => [
                'user:4',
                'user:8',
                'user:5',
                'user:6',
                'user:5'
            ]
        ],
        [
            'auction' => 'auction:nes',
            'bidders' => [
                'user:1',
                'user:4',
                'user:5',
                'user:8',
                'user:johndoe',
                'user:reysubastas'
            ]
        ],
        [
            'auction' => 'auction:darth_vader',
            'bidders' => [
                'user:7',
                'user:4',
                'user:3',
                'user:7',
                'user:reysubastas',
                'user:7',
                'user:reysubastas',
            ]
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $bidFactory = AuctionBidFactory::new();

        foreach (self::DATA as $item) {
            /** @var Auction $auction */
            $auction = $this->getReference($item['auction']);

            $bidGenerator = $this->bidGenerator($auction, $item['bidders']);
            $bids = $bidFactory->createSequence($bidGenerator);

            /** @var AuctionBid $bid */
            foreach ($bids as $bid) {
                $manager->persist($bid);
            }

            // TODO fix winning bid db design
            /*if ($auction->status() === Auction::STATUS_CLOSED) {
                $auction->updateWinningBid(end($bids));
            }*/

            $manager->flush();
        }

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AuctionFixtures::class
        ];
    }

    private function bidGenerator(Auction $auction, array $users): iterable
    {
        $lastBidAmount = $auction->initialAmount();
        $lastBidDate = $auction->createdAt();

        foreach ($users as $user) {
            $user = $this->getReference($user);
            $lastBidAmount = $lastBidAmount + rand(5, 250);
            $lastBidDate = $lastBidDate->add(new DateInterval(sprintf('PT%sM', rand(3, 20))));

            yield [
                'auction' => $auction,
                'user' => $user,
                'amount' => $lastBidAmount,
                'createdAt' => $lastBidDate,
                'updatedAt' => $lastBidDate,
            ];
        }
    }
}
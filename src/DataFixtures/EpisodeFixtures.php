<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODE = [
        1 =>[
            'season'=> 1,
            'title' => 'Welcome to the Playground',
            'number' => '1',
            'synopsis'=> 'épisode 1'
        ],
        2 =>[
            'season'=> 1,
            'title' => 'Welcome to the playground 2',
            'number' => "2",
            'synopsis' => 'Episode 2'
        ],
        3 =>[
            'season'=> 1,
            'title' => 'Welcome to the playground 3',
            'number' => "3",
            'synopsis' => 'Episode 3'
        ]
        ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODE as $keys => $value) {
            $episode = new Episode();
            $episode->setTitle($value['title']);
            $episode->setNumber($value['number']);
            $episode->setSynopsis($value['synopsis']);
            $episode->setSeason($this->getReference('season_'. $value['season'] ));
        $manager->persist($episode);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}

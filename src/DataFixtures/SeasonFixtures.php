<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        1 => [
            'number' => 1,
            'year' => 1999,
            'description' => 'super',
            'program' => 'walkind dead',
        ],
        2 => [
            'number' => 2,
            'year' => 1999,
            'description' => 'super',
            'program' => 'walkind dead',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $keys => $values) {
            $season = new Season();
            $season->setNumber($values['number']);
            $season->setYear($values['year']);
            $season->setDescription($values['description']);
            $season->setProgram($this->getReference('program_'.$values['program']));
            $manager->persist($season);
            $this->addReference('season_'. $values['number'], $season);
        }
    $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class
        ];
   }
}
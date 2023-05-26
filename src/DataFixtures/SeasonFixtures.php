<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    /*const SEASONS = [
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
    }*/
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();
        /**
         * L'objet $faker que tu récupère est l'outil qui va te permettre
         * de te générer toutes les données que tu souhaites
         */
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 0; $j <= 5; $j++) {
            $season = new Season();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                $season->setNumber($j);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
                $this->addReference('program_'. $i . 'season_'. $j, $season);
            }
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
<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        1 =>[
            'title' => 'walkind dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category'=> 'Action'
            ],
        2 =>[
            'title' => 'How I meet your Mother',
            'synopsis' => "l'histoire d'un père de famille qui raconte ca rencontre",
            'category' => 'Aventure'
            ],
        3 =>[
            'title' => 'naruto',
            'synopsis' => "apprentissage ninja",
            'category' => 'Animation'
        ],
        4 =>[
            'title' => 'chucky',
            'synopsis' => "petite poupée adorable qui découpe des personnes",
            'category' => 'Horreur'
        ],
        5 =>[
            'title' => 'bilbon',
            'synopsis' => "découverte de la terre du milieu",
            'category' => 'Fantastique'
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $key => $values) {

            $program = new Program();
            $program->setTitle($values['title']);
            $program->setSynopsis($values['synopsis']);
            $program->setCategory($this->getReference('category_'.$values['category']));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }


}



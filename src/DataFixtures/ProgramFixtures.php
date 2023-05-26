<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        1 =>[
            'title' => 'walkind dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category'=> 'Action',
            'year'=> 2000,
            ],
        2 =>[
            'title' => 'How I meet your Mother',
            'synopsis' => "l'histoire d'un père de famille qui raconte ca rencontre",
            'category' => 'Aventure',
            'year'=> 2000,
            ],
        3 =>[
            'title' => 'naruto',
            'synopsis' => "apprentissage ninja",
            'category' => 'Animation',
            'year'=> 2000,
        ],
        4 =>[
            'title' => 'chucky',
            'synopsis' => "petite poupée adorable qui découpe des personnes",
            'category' => 'Horreur',
            'year'=> 2000,
        ],
        5 =>[
            'title' => 'bilbon',
            'synopsis' => "découverte de la terre du milieu",
            'category' => 'Fantastique',
            'year'=> 1999,
        ],
    ];
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $key => $values) {

            $program = new Program();
            $program->setTitle($values['title']);
            $program->setSynopsis($values['synopsis']);
            $program->setYear($values['year']);
            $program->setCategory($this->getReference('category_'.$values['category']));
            $valueTitle = $values['title'];
            $program->setSlug($this->slugger->slug($program->getTitle()));
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
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



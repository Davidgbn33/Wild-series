<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->lastName);
                for ($j = 1; $j <= 4; $j++) {

                    $actor->addProgram($this->getReference('program_'. rand(1,5)));
            }
                    $manager->persist($actor);
        }
        $this->addReference('actor' .$i, $actor);
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            ProgramFixtures::class
        );
    }

}

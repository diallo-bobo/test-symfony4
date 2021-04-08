<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $names = ['Balcon', 'Rez de chaussé', 'Ouverture'];

        foreach ($names as $name) {
            $manager->persist((new Option())->setName($name));
        }

        $manager->flush();
    }
}

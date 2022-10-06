<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $peugeot = new Brand();
        $peugeot->setName('Peugeot');
        $renault = new Brand();
        $renault->setName('Renault');
        $citroen = new Brand();
        $citroen->setName('Citroen');

        $manager->persist($peugeot);
        $manager->persist($renault);
        $manager->persist($citroen);
        $manager->flush();
    }
}

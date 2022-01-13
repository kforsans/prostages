<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dutInfo = new Formation();
        $dutInfo->setNomCourt("DUT Info");
        $dutInfo->setNomLong("Diplome Universitaire de Technologie en Informatique");
        $manager->persist($dutInfo);
        $manager->flush();
    }
}

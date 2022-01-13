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
        $dutInfo->setNomLong("Diplome Universitaire de Technologie en informatique");
        $manager->persist($dutInfo);
        
        $dutGIM = new Formation();
        $dutGIM->setNomCourt("DUT GIM");
        $dutGIM->setNomLong("Diplome Universitaire de Technologie en génie industriel et maintenance");
        $manager->persist($dutGIM);
        
        $lpProgAv = new Formation();
        $lpProgAv->setNomCourt("LP Prog-Av");
        $lpProgAv->setNomLong("Licence professionnelle en programmation avancée");
        $manager->persist($lpProgAv);
        
        $lpNum = new Formation();
        $lpNum->setNomCourt("LP Num");
        $lpNum->setNomLong("Licence professionnelle de métiers du numérique");
        $manager->persist($lpNum);
        
        $manager->flush();
    }
}

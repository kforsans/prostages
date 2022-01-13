<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR'); // Localisation Française Faker

        //-----FORMATIONS-----

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

        //-----ENTREPRISES-----

        $nbEntreprises = 10;

        for ($i=1; $i <= $nbEntreprises; $i++){
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company());
            $entreprise->setActivite($faker->jobTitle());
            $entreprise->setAdresse($faker->address());
            $entreprise->setUrlSite($faker->domainName());
            $manager->persist($entreprise);
        }

        //-----STAGES-----

        $nbStages = 30;

        for ($i=1; $i <= $nbStages; $i++){
            $stage = new Stage();
            $stage->setTitre('titre');
            $stage->setDescMission($faker->realText($maxNbChars = 300, $indexSize = 2));
            $stage->setEmailContact($faker->companyEmail());
            $manager->persist($stage);
        }
        
        $manager->flush();
    }
}

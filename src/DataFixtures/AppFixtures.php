<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $nathan = new User();
        $nathan -> setPrenom("Nathan");
        $nathan -> setNom("gouvet");
        $nathan -> setEmail("nathan@gmail.fr");
        $nathan -> setRoles(['ROLE_USER','ROLE_ADMIN']);
        $nathan -> setPassword('$2y$10$rk.KhkbEQIlbwZ4RbjSEqOSULSGiSD9Gudfix22Y7OcDQer.gqtUe');
        $manager -> persist($nathan);

        $kevin = new User();
        $kevin -> setPrenom("kevin");
        $kevin -> setNom("forsans");
        $kevin -> setEmail("kevin@gmail.fr");
        $kevin -> setRoles(['ROLE_USER']);
        $kevin -> setPassword('$2y$10$fN4TN2opqrBOqqa457kNpebwzJrV6USKeKXF1mDmlZaus.zdywNua');
        $manager -> persist($kevin);

        $faker = \Faker\Factory::create('fr_FR'); // Localisation Française Faker

        //-----FORMATIONS-----

        $dutInfo = new Formation();
        $dutInfo->setNomCourt("DUT Info");
        $dutInfo->setNomLong("Diplome Universitaire de Technologie en informatique");
        
        $dutGIM = new Formation();
        $dutGIM->setNomCourt("DUT GIM");
        $dutGIM->setNomLong("Diplome Universitaire de Technologie en génie industriel et maintenance");

        $lpProgAv = new Formation();
        $lpProgAv->setNomCourt("LP Prog-Av");
        $lpProgAv->setNomLong("Licence professionnelle en programmation avancée");
        
        $lpNum = new Formation();
        $lpNum->setNomCourt("LP Num");
        $lpNum->setNomLong("Licence professionnelle de métiers du numérique");

        $tabFormations = array($dutGIM, $dutInfo, $lpNum, $lpProgAv);
        foreach ($tabFormations as $formation){
            $manager->persist($formation);
        }

        //-----ENTREPRISES-----

        $nbEntreprises = 10;
        

        for ($i=1; $i <= $nbEntreprises; $i++){
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company());
            $entreprise->setActivite($faker->jobTitle());
            $entreprise->setAdresse($faker->address());
            $entreprise->setUrlSite($faker->domainName());

            $manager->persist($entreprise);

            $tabEntreprises[]=$entreprise;

        }

        //-----STAGES-----

        $nbStages = 30;

        for ($numStage=1; $numStage <= $nbStages; $numStage++){
            $stage = new Stage();
            $stage->setTitre($faker->jobTitle());
            $stage->setDescMission($faker->realText($maxNbChars = 300, $indexSize = 2));
            $stage->setEmailContact($faker->companyEmail());
            
            $entrepriseConcernee = $faker->numberBetween($min = 0, $max = count($tabEntreprises)-1);
            $tabEntreprises[$entrepriseConcernee] -> addStage($stage);
            $manager->persist($stage);

            $nbFormationsConcernees = $faker->numberBetween($min = 0, $max = count($tabFormations)-1);
            for($i=0; $i <= $nbFormationsConcernees; $i++){
                $formationConcernee = $faker->numberBetween($min = 0, $max = count($tabFormations)-1);
                $tabFormations[$formationConcernee] -> addStage($stage);
                $manager->persist($tabFormations[$formationConcernee]);
            }
            
            
            $manager->persist($stage);
        }

        
        
        $manager->flush();
    }
}

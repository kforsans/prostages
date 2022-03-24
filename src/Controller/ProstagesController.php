<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Form\FormationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stages = $repositoryStage->findAll();

        return $this->render('prostages/index.html.twig', ['stages' => $stages]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entrepries(): Response
    {
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprises = $repositoryEntreprise->findAll();

        return $this->render('prostages/entreprises.html.twig', ['entreprises' => $entreprises]);
    }

    /**
     * @Route("/entreprises/ajouter", name="ajout-entreprise")
     */
    public function ajouterEntreprise (Request $requete, EntityManagerInterface $manager)
	{
        // Création d'une ressource initialement vierge
        $entreprise = new Entreprise ();

        $formulaireEntreprise = $this -> createForm ( EntrepriseType::class,$entreprise );

        $formulaireEntreprise -> handleRequest ( $requete );

        if($formulaireEntreprise->isSubmitted()&& $formulaireEntrepriseModif->isValid())
        {
        // Enregistrer la date d'ajout de la ressource
        $entreprise -> setDateAjout (new \DateTime ());
        // Enregistrer la ressource en BD

        $manager -> persist ($entreprise);
        $manager -> flush ();

        // Rediriger l' utilisateur vers la page affichant la liste des ressources
        return $this -> redirectToRoute ('accueil');

        }
        // Afficher la page d'ajout d'une entreprise
        return $this -> render ('prostages/ajoutEntreprise.html.twig ',
        ['vueFormulaire' => $formulaireEntreprise -> createView ()]);
	}
    /**
     * @Route("/entreprises/modifier/{id}", name="modifier-entreprise")
     */
    public function modifierEntreprise (Request $requete, EntityManagerInterface $manager, Entreprise $entreprise)
    {
    $formulaireEntrepriseModif = $this -> createForm ( EntrepriseType::class,$entreprise );

    $formulaireEntrepriseModif -> handleRequest ( $requete );

    if($formulaireEntrepriseModif->isSubmitted() && $formulaireEntrepriseModif->isValid())
    {
        // Enregistrer la ressource en BD
        $manager -> persist ($entreprise);
        $manager -> flush ();
        // Rediriger l' utilisateur vers la page affichant la liste des ressources
        return $this -> redirectToRoute ('accueil');
    }
    // Afficher la page d'ajout d'une entreprise
    return $this -> render ('prostages/ajoutEntreprise.html.twig ',
    ['vueFormulaire' => $formulaireEntrepriseModif -> createView ()]);
    }

    /**
     * @Route("/stages-entreprise/{id}", name="stages-entreprise")
     */
    public function stages_entreprise($id): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprise = $repositoryEntreprise->find($id);
        $stages = $repositoryStage->findByEntreprise($id);

        return $this->render('prostages/stages-entreprise.html.twig', [
            'stages' => $stages,
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations(): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formations = $repositoryFormation->findAll();

        return $this->render('prostages/formations.html.twig', ['formations' => $formations]);
    }

    /**
     * @Route("/stages-formation/{id}", name="stages-formation")
     */
    public function stages_formation($id): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formation = $repositoryFormation->find($id);
        $stages = $repositoryStage->findByFormation($id);

        return $this->render('prostages/stages-formation.html.twig', [
            'stages' => $stages,
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/stage/{id}", name="stage-id")
     */
    public function stage($id): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stage = $repositoryStage->find($id);

        return $this->render('prostages/stage-id.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
	 * @Route ("/stages/ajouter" , name ="ajouter_stage")
	 */
	public function ajouterStage (Request $requete, EntityManagerInterface $manager)
	{
        // Création d'une ressource initialement vierge
        $stage = new Stage ();

        $formulaireStage = $this -> createForm ( StageType::class,$stage );
        $formulaireStage -> handleRequest ( $requete);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
        {
            // Enregistrer la ressource en BD
            $manager -> persist ($stage);
            $manager -> flush ();
            // Rediriger l' utilisateur vers la page affichant la liste des ressources
            return $this -> redirectToRoute ('accueil');

        }
        // Afficher la page d'ajout d'une entreprise
        return $this -> render ('prostages/ajoutStage.html.twig ',
        ['vueFormulaireStage' => $formulaireStage -> createView ()]);
	}

	/**
	 * @Route ("/stage/modifier/{id}" , name ="modifier_stage")
	 */
	public function modifierStage (Request $requete, EntityManagerInterface $manager, Stage $stage)
		{

		$formulaireStage = $this -> createForm (StageType::class,$stage );
		$formulaireStage -> handleRequest ( $requete);

		if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
		{
		// Enregistrer la ressource en BD
		$manager -> persist ($stage);
		$manager -> flush ();
		// Rediriger l' utilisateur vers la page affichant la liste des ressources
		return $this -> redirectToRoute ('accueil');

		}
		// Afficher la page d'ajout d'une entreprise
		return $this -> render ('prostages/ajoutStage.html.twig ',
		['vueFormulaireStage' => $formulaireStage -> createView ()]);
		}
}

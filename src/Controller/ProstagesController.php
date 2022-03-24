<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
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

        // création d'un objet formulaire pour ajouter une ressource
        $formulaireEntreprise = $this -> createFormBuilder ( $entreprise )
            -> add ('nom')
            -> add ('activite')
            -> add ('adresse')
            -> add ('urlSite')
            -> getForm ();
        $formulaireEntreprise -> handleRequest ( $requete );

        if($formulaireEntreprise->isSubmitted()&& $formulaireEntrepriseModif->isValid())
        {
        // Enregistrer la date d'ajout de la ressource
        $entreprise -> setDateAjout (new \DateTime ());
        // Enregistrer la ressource en BD

        $manager -> persist ($entreprise);
        $manager -> flush ();

        // Rediriger l' utilisateur vers la page affichant la liste des ressources
        return $this -> redirectToRoute ('prostages_accueil');

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
    // création d'un objet formulaire pour ajouter une ressource
    $formulaireEntrepriseModif = $this -> createFormBuilder ( $entreprise )
            -> add ('nom', TextType::class)
            -> add ('activite', TextType::class)
            -> add ('adresse', TextType::class)
            -> add ('urlSite', UrlType::class)
            -> getForm ();

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
    return $this -> render ('prostages/modifierEntreprise.html.twig ',
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
}

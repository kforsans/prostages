<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

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

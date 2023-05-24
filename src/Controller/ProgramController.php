<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }
// le requirement permet le retour d'une page 404 //

    #[Route('/show/{id}', name: 'show', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=> $id]);

// vérification de l'id dans la table program
        if(!$program){
            throw $this->createNotFoundException(
                'No porgram with id : ' .$id. ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program
            ]);
    }
 #[Route('/{programId}/seasons/{seasonId}', name: 'season_show',methods: ['get'])]
    public function showSeason(ProgramRepository $programRepository, SeasonRepository $seasonRepository,int $programId, int $seasonId)
    {
        $program = $programRepository->findOneBy(['id'=> $programId]);
            $season = $seasonRepository->findOneBy(['id'=> $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

}
<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


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
    public function show(Program $program): Response
    {
        /*$program = $programRepository->findOneBy(['id'=> $id]);*/

// vérification de l'id dans la table program
        /*if(!$program){
            throw $this->createNotFoundException(
                'No porgram with id : ' .$id. ' found in program\'s table.'
            );
        }*/
        return $this->render('program/show.html.twig', [
            'program' => $program
            ]);
    }
 #[Route('/{programId}/seasons/{seasonId}', name: 'season_show',methods: ['get'])]
 #[Entity('program', options: ['mapping'=> ['programId'=>'id']])]
 #[Entity('season', options: ['mapping'=>['seasonId'=>'id']])]
    public function showSeason(Program $program, Season $season,int $programId, int $seasonId)
    {


        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }
#[Route('/program/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show', methods: ['get'])]
#[Entity('program', options: ['mapping'=>['programId'=>'id']])]
#[Entity('season', options: ['mapping'=>['seasonId'=>'id']])]
#[Entity('episode', options: ['mapping'=>['episodeId'=>'id']])]
    public function ShowEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program'=> $program,
            'season'=> $season,
            'episode'=>$episode,
        ]);
    }

}
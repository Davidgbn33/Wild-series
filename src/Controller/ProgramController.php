<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
        ]);
    }
// le requirement permet le retour d'une page 404 //

    #[Route('/list/{page}', name: 'list', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function show(int $page): Response
    {
        return $this->render('program/show.html.twig', [
            'page' => $page]);

    }
}
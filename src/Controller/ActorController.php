<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();
        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    #[Route('/actor/{id}', name: 'show', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function show(Actor $actor
    ): Response
    {

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,

        ]);
    }
#[Route('/new', name: 'new')]
    public function new(Request $request, ActorRepository $actorRepository,  )
{
    $actor = new Actor();
    $form = $this->createForm(ActorType::class, $actor);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $actorRepository->save($actor, true);

        $this->addFlash('success', 'the message à bien été crée');

        return $this->redirectToRoute('actor_index');
    }

    return $this->render('actor/new.html.twig', ['form'=> $form]);
}
    }

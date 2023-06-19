<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Form\EpisodeType;
use App\Repository\CommentRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/episode', name: 'episode_')]
class EpisodeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EpisodeRepository $episodeRepository): Response
    {





        return $this->render('episode/index.html.twig', [
            'episodes' => $episodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EpisodeRepository $episodeRepository, ProgramRepository $programRepository,MailerInterface $mailer, SluggerInterface $slugger): Response
    {
        $program = $programRepository->findAll();
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($episode->getTitle());
            $episode->setSlug($slug);
            $episodeRepository->save($episode, true);
            $email = (new Email())

                ->from('gibon.david@live.fr')
                ->to('gibon.david@live.fr')
                ->subject('Un nouvel épisode vient d\'être publiée !')
                ->html($this->renderView('episode/newEpisodeEmail.html.twig', ['episode'=> $episode, 'program' => $episode->getSeason()->getProgram()]));

            $mailer->send($email);

            return $this->redirectToRoute('episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('episode/new.html.twig', [
            'episode' => $episode,
            'form' => $form,
            'program'=> $program,
        ]);
    }


    #[Route('/{slug}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Request $request,Episode $episode, CommentRepository $commentRepository): Response
    {


        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setEpisode($episode);
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('episode_index', [], Response::HTTP_SEE_OTHER);
        }

        $comment = $commentRepository->findBy(['episode' => $episode]);

        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
            'comment' => $comment,
            'form' => $form,
        ]);
    }


    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Episode $episode, EpisodeRepository $episodeRepository): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $episodeRepository->save($episode, true);


            return $this->redirectToRoute('episode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('episode/edit.html.twig', [
            'episode' => $episode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Episode $episode, EpisodeRepository $episodeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $episodeRepository->remove($episode, true);
        }
        $this->addFlash('danger', 'The new program has been deleted');

        return $this->redirectToRoute('episode_index', [], Response::HTTP_SEE_OTHER);
    }
}

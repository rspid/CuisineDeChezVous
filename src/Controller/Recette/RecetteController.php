<?php

namespace App\Controller\Recette;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Entity\Commentaire;
use App\Entity\RecetteNote;
use App\Form\CommentaireType;
use App\Service\FileUploader;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecetteNoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recherche')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'recette_index', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('recette/index.html.twig', [
            'recettes' => $recetteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'recette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUp): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        $extension = ["png", "jpg"];

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get("image")->getData();

            $recette->setDatePublication(new \DateTime('now'));

            $recette->setCreateur($this->getUser());

            $filename = $fileUp->upload($file, $extension);

            if ($filename) {
                $recette->setNomImage($filename);
                $entityManager->persist($recette);
                $entityManager->flush();
            }

            return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recette_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setRecette($recette);

            $commentaire->setUser($this->getUser());

            $commentaire->setDatePublication(new \DateTime(('now')));

            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('recette_show', ['id' => $recette->getId()]);
        }
        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'recette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recette_delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/note', name: 'recette_note')]
    public function note(Recette $recette, EntityManagerInterface $entityManager, RecetteNoteRepository $noteRepo): Response
    {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Non autorisé"
        ], 403);

        if ($recette->isNoteByUser($user)) {
            $note = $noteRepo->findOneBy([
                'recette' => $recette,
                'user' => $user
            ]);
            $entityManager->remove($note);
            $entityManager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Note bien supprimé',
                'notes' => $noteRepo->count(['recette' => $recette])
            ], 200);
        }

        $note = new RecetteNote();
        $note->setRecette($recette)
            ->setUser($user);

        $entityManager->persist($note);
        $entityManager->flush();


        return $this->json([
            'code' => 200,
            'message' => 'Note bien ajouté',
            'notes' => $noteRepo->count(['recette' => $recette])
        ], 200);
    }
}

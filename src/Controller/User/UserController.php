<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/save', name: 'user_save', methods: ['GET'])]
    public function save(User $user): Response
    {
        return $this->render('user/save.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/fav', name: 'user_fav', methods: ['GET'])]
    public function fav(User $user): Response
    {
        return $this->render('user/fav.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/create', name: 'user_create', methods: ['GET'])]
    public function create(User $user): Response
    {
        return $this->render('user/create.html.twig', [
            'user' => $user,
        ]);
    }
}

<?php

namespace App\Controller;


use App\Service\RecetteRandom;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(CategorieRepository $categorieRepository,RecetteRepository $recetteRepository ): Response
    {
        $recette = $recetteRepository->findOneBy(array('isRecetteDuJour' => true));

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categories' => $categorieRepository->findAll(),
            'recetteDuJour' => $recetteRepository->findOneBy(array('id'=> $recette->getId())),
        ]);
    }
}

<?php

namespace App\Controller;


use App\Service\RecetteRandom;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(CategorieRepository $categorieRepository, RecetteRandom $rr): Response
    {

        /* Il faudrait revoir la méthode pour que la fonction s'éffectue à minuit chaque jour
        pour que cela soit vraiment la recette du jour
        */

        $today = time();
        $lastUtilisation = 1643763243;
        //$day=86400;
        $minute = 60;

        if ($today - $lastUtilisation >= $minute) {
            $recetteAleatoire = $rr->randomId();
            $lastUtilisation = time();
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categories' => $categorieRepository->findAll(),
            'rr' => $recetteAleatoire
        ]);
    }
}

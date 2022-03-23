<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecetteRepository;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'apropos')]
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('apropos/index.html.twig', [
            'controller_name' => 'AproposController',
            'recetteDuJour' => $recetteRepository->findOneBy(array('isRecetteDuJour' => true)),
        ]);
    }
}

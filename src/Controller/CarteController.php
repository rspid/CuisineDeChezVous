<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'carte')]
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('carte/index.html.twig', [
            'controller_name' => 'CarteController',
            'recetteDuJour' => $recetteRepository->findOneBy(array('isRecetteDuJour' => true)),
        ]);
    }
}

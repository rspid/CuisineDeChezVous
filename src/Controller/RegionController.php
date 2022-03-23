<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecetteRepository;

#[Route('/region')]
class RegionController extends AbstractController
{
    #[Route('/', name: 'region_index', methods: ['GET'])]
    public function index(RegionRepository $regionRepository,RecetteRepository $recetteRepository): Response
    {
        return $this->render('region/index.html.twig', [
            'regions' => $regionRepository->findAll(),
            'recetteDuJour' => $recetteRepository->findOneBy(array('isRecetteDuJour' => true)),
        ]);
    }

    #[Route('/{id}', name: 'region_show', methods: ['GET'])]
    public function show(Region $region,RecetteRepository $recetteRepository): Response
    {
        return $this->render('region/show.html.twig', [
            'region' => $region,
            'recetteDuJour' => $recetteRepository->findOneBy(array('isRecetteDuJour' => true)),
        ]);
    }
}

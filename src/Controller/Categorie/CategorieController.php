<?php

namespace App\Controller\Categorie;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{nom}', name: 'categorie')]
    public function index(ManagerRegistry $doctrine, $nom): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->findOneByNom(array('nom' => $nom));
        $recetteCateg = [];
        if (!empty($categorie)) {
            $recetteCateg = $categorie->getRecettes();
        }


        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'recetteCateg' => $recetteCateg,
            'categorie' => $categorie
        ]);
    }
}

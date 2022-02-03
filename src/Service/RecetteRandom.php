<?php

namespace App\Service;

use App\Entity\Recette;
use Doctrine\Persistence\ManagerRegistry;


class RecetteRandom
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function randomId(): Recette
    {
        $enregitrements = $this->doctrine->getRepository(Recette::class)->findAll();

        $tabId = array();

        foreach ($enregitrements as $enr) {
            $tabId[] = $enr->getId();
        }

        $id = array_rand($tabId, 1);

        shuffle($tabId); // Pour mélanger le tableau

        $idRecetteRandom = $tabId[$id];

        $recetteRandom = $this->doctrine->getRepository(Recette::class)->find($idRecetteRandom);

        return $recetteRandom;
    }

    function setInterval($f, $milliseconds)
    {
        $seconds = (int)$milliseconds / 1000;
        while (true) {
            $f();
            sleep($seconds);
        }
    }
}

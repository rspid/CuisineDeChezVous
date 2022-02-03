<?php

namespace App\Repository;

use App\Entity\RecetteNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecetteNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecetteNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecetteNote[]    findAll()
 * @method RecetteNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecetteNote::class);
    }
}

<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function findAllOrdonnes(): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.ordreAffichage', 'ASC')
            ->addOrderBy('l.datePublication', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
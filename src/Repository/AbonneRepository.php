<?php

namespace App\Repository;

use App\Entity\Abonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AbonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonne::class);
    }

    public function existeDeja(string $email): bool
    {
        return null !== $this->createQueryBuilder('a')
            ->where('a.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
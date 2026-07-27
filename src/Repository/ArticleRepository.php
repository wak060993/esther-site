<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findPublies(?int $categorieId = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('a.datePublication', 'DESC');

        if ($categorieId) {
            $qb->andWhere('a.categorie = :cat')->setParameter('cat', $categorieId);
        }

        return $qb->getQuery()->getResult();
    }
}
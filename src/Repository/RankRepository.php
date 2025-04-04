<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Game;

class RankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getGamesByLineId($lineId)
    { // Requête qui récupère la liste des parties en fonction d'une ligne de métro
        return $this->createQueryBuilder('g')
            ->join('g.user', 'u')
            ->where('g.user IS NOT NULL')
            ->andWhere('g.line = :lineId')
            ->andWhere('g.isFinished = true')
            ->setParameter('lineId', $lineId)
            ->orderBy('g.time', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getPlayedLines()
    { 
        return $this->getEntityManager()->createQueryBuilder()
            ->select('DISTINCT l')
            ->from('App\Entity\Line', 'l')
            ->innerJoin('App\Entity\Game', 'g', 'WITH', 'g.line = l')
            ->where('g.user IS NOT NULL')
            ->andWhere('g.isFinished = true')
            ->getQuery()
            ->getResult();
    }
}

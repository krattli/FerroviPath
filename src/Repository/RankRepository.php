<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Game;
use App\Entity\Line;

class RankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getGamesByLineId($lineId)
    {
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
        return $this->getEntityManager()->createQuery(
            'SELECT DISTINCT l FROM App\Entity\Line l
             JOIN App\Entity\Game g WITH g.line = l WHERE g.user IS NOT NULL'
        )->getResult();
    }
}

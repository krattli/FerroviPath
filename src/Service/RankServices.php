<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RankServices
{
    public static function getGames(Request $request, EntityManagerInterface $entityManager)
    {
        $selectedLineId = $request->query->get('line');

        $games = [];

        if ($selectedLineId) {
            $query = $entityManager->createQuery(
                'SELECT g FROM App\Entity\Game g JOIN g.user u
                 WHERE g.user IS NOT NULL AND g.line = :lineId AND g.isFinished = true
                 ORDER BY g.time ASC'
            )->setParameter('lineId', $selectedLineId);


            $games = $query->getResult();
        }

        return $games;
    }

    public static function getplayedLines(EntityManagerInterface $entityManager)
    {
        $linesQuery = $entityManager->createQuery(
            'SELECT DISTINCT l FROM App\Entity\Line l
             JOIN App\Entity\Game g WITH g.line = l WHERE g.user IS NOT NULL'
        );
        return $linesQuery->getResult();
    }
}
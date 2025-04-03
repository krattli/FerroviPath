<?php

namespace App\Controller;

use App\Entity\Line;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankController extends AbstractController
{
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function rankByLine(Request $request, EntityManagerInterface $entityManager): Response
    {
        $linesQuery = $entityManager->createQuery(
            'SELECT DISTINCT l
         FROM App\Entity\Game g
         JOIN g.line l
         WHERE g.user IS NOT NULL'
        );
        $lines = $linesQuery->getResult();

        $selectedLineId = $request->query->get('line');

        $query = $entityManager->createQuery(
            'SELECT u.pseudo, SUM(g.scorePoints) as totalScore
        FROM App\Entity\Game g
        JOIN g.user u
        WHERE g.user IS NOT NULL
        GROUP BY u.idUser
        ORDER BY totalScore DESC'
        );
        $joueurs = $query->getResult();

        if ($selectedLineId) {
            $query = $entityManager->createQuery(
                'SELECT u.pseudo, SUM(g.scorePoints) as totalScore
            FROM App\Entity\Game g
            JOIN g.user u
            WHERE g.user IS NOT NULL
            AND g.line = :lineId
            GROUP BY u.idUser
            ORDER BY totalScore DESC'
            )->setParameter('lineId', $selectedLineId);

            $joueurs = $query->getResult();
        }

        return $this->render('rank/index.html.twig', [
            'joueurs' => $joueurs,
            'lines' => $lines,
            'selectedLineId' => $selectedLineId,
        ]);
    }
}

?>
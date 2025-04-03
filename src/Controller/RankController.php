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
        // D'abors, on selectionne toutes les lignes sur lesquelles au moins une partie est jouée (pour la balise select)
        $linesQuery = $entityManager->createQuery(
            'SELECT DISTINCT l FROM App\Entity\Line l
             JOIN App\Entity\Game g WITH g.line = l WHERE g.user IS NOT NULL'
        );
        $lines = $linesQuery->getResult();

        $selectedLineId = $request->query->get('line');
        $games = [];

        // Ensuite, on selectionne toutes les parties qui ont été jouées
        if ($selectedLineId) {
            $query = $entityManager->createQuery(
            'SELECT g FROM App\Entity\Game g JOIN g.user u
                 WHERE g.user IS NOT NULL AND g.line = :lineId AND g.isFinished = true
                 ORDER BY g.time ASC'
            )->setParameter('lineId', $selectedLineId);


            $games = $query->getResult();
        }

        return $this->render('rank/index.html.twig', [
            'games' => $games,
            'lines' => $lines,
            'selectedLineId' => $selectedLineId,
        ]);
    }
}

?>
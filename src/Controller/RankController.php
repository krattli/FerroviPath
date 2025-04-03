<?php

namespace App\Controller;

use App\Entity\Line;
use App\Repository\UserRepository;
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
        // Récupère toutes les lignes présentes dans la BDD
        $lines = $entityManager->getRepository(Line::class)->findAll();
        $selectedLineId = $request->query->get('line');

        $joueurs = [];

        if ($selectedLineId) {
            $query = $entityManager->createQuery(
                'SELECT u.idUser, u.pseudo, SUM(g.scorePoints) as totalScore
            FROM App\Entity\Game g
            JOIN g.user u
            WHERE g.line = :lineId AND u IS NOT NULL
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
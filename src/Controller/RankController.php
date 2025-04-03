<?php

namespace App\Controller;

use App\Entity\Line;
use App\Service\RankServices;
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
        $lines = RankServices::getplayedLines($entityManager);
        $games = RankServices::getGames($request, $entityManager);
        $selectedLineId = $request->query->get('line');

        return $this->render('rank/index.html.twig', [
            'games' => $games,
            'lines' => $lines,
            'selectedLineId' => $selectedLineId,
        ]);
    }
}

?>
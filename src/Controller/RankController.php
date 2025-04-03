<?php

namespace App\Controller;

use App\Repository\RankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankController extends AbstractController
{
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function rankByLine(Request $request, RankRepository $rankRepository): Response
    {
        $selectedLineId = $request->query->get('line');
        $lines = $rankRepository->getPlayedLines();
        $games = $rankRepository->getGamesByLineId($selectedLineId);

        return $this->render('rank/index.html.twig', [
            'games' => $games,
            'lines' => $lines,
            'selectedLineId' => $selectedLineId,
        ]);
    }
}

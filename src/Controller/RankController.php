<?php

namespace App\Controller;

use App\Repository\RankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankController extends AbstractController
{

    public function __construct(private RankRepository $rankRepository) {

    }
    #[Route('/rank', name: 'ferrovipath_rank', methods: ['GET'])]
    public function rankByLine(Request $request): Response
    {
        $selectedLineId = $request->query->get('line');
        $lines = $this->rankRepository->getPlayedLines();
        $games = $this->rankRepository->getGamesByLineId($selectedLineId);

        return $this->render('rank/index.html.twig', [
            'games' => $games,
            'lines' => $lines,
            'selectedLineId' => $selectedLineId,
        ]);
    }
}

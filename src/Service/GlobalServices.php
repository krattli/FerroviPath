<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\LineRepository;
use App\Repository\GameRepository;

class GlobalServices
{
    public function __construct(
        private LineRepository $lineRepository,
        private GameRepository $gameRepository
    ) {}

    public function getLines(): array // Variables globales qui récupèrent la liste des lignes de métro
    {
        return $this->lineRepository->findAll();
    }

    public function getGames(?int $userId = null): array // Variable qui récupères toutes les parties d'un utilisateur
    {
        return $this->gameRepository->findSavedGames($userId);
    }
}

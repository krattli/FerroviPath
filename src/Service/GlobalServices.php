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

    public function getLines(): array
    {
        return $this->lineRepository->findAll();
    }

    public function getGames(?int $userId = null): array
    {
        return $this->gameRepository->findSavedGames($userId);
    }
}

<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use App\Entity\Line;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameServices{

    public static function saveGame(Request $request, EntityManagerInterface $entityManager):void // Sauvegarde d'une partie
    {
        $data = json_decode($request->getContent(), true);

        // Si un idGame existe, on update une partie déjà existante donc pas d'enregistrement de nouvelle partie
        if (!empty($data['idGame'])) {
            $game = $entityManager->getRepository(Game::class)->find($data['idGame']);
        } else {
            $game = new Game();
        }

        $game->setUpdatedAt(new \DateTime());

        $game->setTime($data['time']);
        $game->setScorePoints($data['scorePoints']);
        $game->setCompletedStations($data['completedStations']);
        $game->setGameMode($data['gameMode']);
        $game->setIsFinished($data['isFinished'] ?? false);

        $line = $entityManager->getReference(Line::class, $data['idLine']);
        $game->setLine($line);

        // Gestion d'enregistrement de l'utilisateur
        // Si l'id est -1, la partie est enregistrée en anonyme (user=null)
        if (isset($data['idUser']) && $data['idUser'] != -1) {
            $user = $entityManager->getRepository(User::class)->find($data['idUser']);
            $game->setUser($user);
        }

        $entityManager->persist($game);
        $entityManager->flush();
    }

}

?>
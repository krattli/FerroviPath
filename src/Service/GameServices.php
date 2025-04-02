<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GameServices{

    public function __construct(private EntityManagerInterface $entityManager){

    }

    public function saveGame($file):void
    {
        $data = json_decode($file, true);
        $game = new Game();
        $game->setTime($data['time']);
        $game->setScorePoints($data['scorePoints']);
        $game->setCompletedStations($data['completedStations']);
        $game->setGameMode($data['gameMode']);

        $line = $this->entityManager->getReference('App\Entity\Line', $data['idLine']);
        $game->setLine($line);

        // Gestion d'enregistrement de l'utilisateur
        // Si l'id est -1, la partie est enregistrée en anonyme (user=null)
        if (isset($data['idUser']) && $data['idUser'] != -1) {
            $user = $this->entityManager->getRepository(User::class)->find($data['idUser']);
            $game->setUser($user);
        }

        $this->entityManager->persist($game);
        $this->entityManager->flush();   
    }

}

?>
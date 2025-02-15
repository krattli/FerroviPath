<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idGame = null;

    #[ORM\Column(length: 255)]
    private ?string $gameMode = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?float $time = null;

    #[ORM\Column]
    private ?int $scorePoints = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $completedStations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function setIdGame(int $idGame): static
    {
        $this->idGame = $idGame;

        return $this;
    }

    public function getGameMode(): ?string
    {
        return $this->gameMode;
    }

    public function setGameMode(string $gameMode): static
    {
        $this->gameMode = $gameMode;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?float
    {
        return $this->time;
    }

    public function setTime(float $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getScorePoints(): ?int
    {
        return $this->scorePoints;
    }

    public function setScorePoints(int $scorePoints): static
    {
        $this->scorePoints = $scorePoints;

        return $this;
    }

    public function getCompletedStations(): ?array
    {
        return $this->completedStations;
    }

    public function setCompletedStations(?array $completedStations): static
    {
        $this->completedStations = $completedStations;

        return $this;
    }
}

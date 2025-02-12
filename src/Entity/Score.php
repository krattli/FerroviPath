<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $time = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?int $scorePoints = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $stationCompletes = [];

    #[ORM\Column]
    private ?int $idReseau = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

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

    public function getStationCompletes(): array
    {
        return $this->stationCompletes;
    }

    public function setStationCompletes(array $stationCompletes): static
    {
        $this->stationCompletes = $stationCompletes;

        return $this;
    }

    public function getIdReseau(): ?int
    {
        return $this->idReseau;
    }

    public function setIdReseau(int $idReseau): static
    {
        $this->idReseau = $idReseau;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameStation = null;

    #[ORM\Column]
    private ?bool $isTerminus = null;

    #[ORM\Column(type: Types::OBJECT, nullable: true)]
    private ?object $nextStation = null;

    #[ORM\Column]
    private ?int $X = null;

    #[ORM\Column]
    private ?int $Y = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameStation(): ?string
    {
        return $this->nameStation;
    }

    public function setNameStation(string $nameStation): static
    {
        $this->nameStation = $nameStation;

        return $this;
    }

    public function isTerminus(): ?bool
    {
        return $this->isTerminus;
    }

    public function setIsTerminus(bool $isTerminus): static
    {
        $this->isTerminus = $isTerminus;

        return $this;
    }

    public function getNextStation(): ?object
    {
        return $this->nextStation;
    }

    public function setNextStation(?object $nextStation): static
    {
        $this->nextStation = $nextStation;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->X;
    }

    public function setX(int $X): static
    {
        $this->X = $X;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->Y;
    }

    public function setY(int $Y): static
    {
        $this->Y = $Y;

        return $this;
    }
    
    public function getStationPossible(Station $station): array{
        return [];
    }
}

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
    private ?int $axisX = null;

    #[ORM\Column]
    private ?int $axisY = null;

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

    public function getX(): ?int
    {
        return $this->axisX;
    }

    public function setX(int $axisX): static
    {
        $this->axisX = $axisX;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->axisY;
    }

    public function setY(int $axisY): static
    {
        $this->axisY = $axisY;

        return $this;
    }
    
    public function getStationPossible(Station $station): array{
        return [];
    }
}

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
    private ?int $idStation = null;

    #[ORM\Column(length: 255)]
    private ?string $nameStation = null;

    #[ORM\Column]
    private ?float $axisX = null;

    #[ORM\Column]
    private ?float $axisY = null;

    #[ORM\Column]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    public function getId(): ?int
    {
        return $this->idStation;
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

    public function getAxisX(): ?float
    {
        return $this->axisX;
    }

    public function setAxisX(float $axisX): static
    {
        $this->axisX = $axisX;

        return $this;
    }

    public function getAxisY(): ?float
    {
        return $this->axisY;
    }

    public function setAxisY(float $axisY): static
    {
        $this->axisY = $axisY;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}

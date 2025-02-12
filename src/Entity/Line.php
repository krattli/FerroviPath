<?php

namespace App\Entity;

use App\Repository\LineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineRepository::class)]
class Line
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameLine = null;

    #[ORM\Column(length: 255)]
    private ?string $IdLine = null;

    #[ORM\Column(type: Types::JSON)]
    private array $stations = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLine(): ?string
    {
        return $this->nameLine;
    }

    public function setNameLine(string $nameLine): static
    {
        $this->nameLine = $nameLine;

        return $this;
    }

    public function getIdLine(): ?string
    {
        return $this->IdLine;
    }

    public function setIdLine(string $IdLine): static
    {
        $this->IdLine = $IdLine;

        return $this;
    }

    public function getStations(): array
    {
        return $this->stations;
    }

    public function setStations(array $stations): static
    {
        $this->stations = $stations;

        return $this;
    }
}

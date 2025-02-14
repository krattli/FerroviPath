<?php

namespace App\Entity;

use App\Repository\LineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineRepository::class)]
class Line
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idLine = null;

    #[ORM\Column(length: 255)]
    private ?string $nameLine = null;

    public function getId(): ?int
    {
        return $this->idLine;
    }

    public function setId(int  $idLine): void
    {
        $this->idLine = $idLine;
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

}

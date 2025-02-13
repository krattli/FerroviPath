<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Network
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $idReseau;

    #[ORM\Column(type: 'string', length: 255)]
    private string $ville;

    #[ORM\OneToMany(targetEntity: Line::class, mappedBy: 'reseau', cascade: ['persist', 'remove'])]
    private Collection $lines;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    public function getIdReseau(): int
    {
        return $this->idReseau;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function addLigne(Line $ligne): self
    {
        if (!$this->lines->contains($ligne)) {
            $this->lines->add($ligne);
        }
        return $this;
    }

    public function removeLigne(Line $ligne): self
    {
        $this->lines->removeElement($ligne);
        return $this;
    }
}

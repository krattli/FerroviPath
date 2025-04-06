<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_Station = null;

    #[ORM\Column(length: 255)]
    private ?string $nameStation = null;

    #[ORM\Column]
    private ?float $axisX = null;

    #[ORM\Column]
    private ?float $axisY = null;
    
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable:true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'stations')]
    #[ORM\JoinColumn(name: 'id_line', referencedColumnName: 'idLine', nullable: false)]
    private ?Line $line = null;

    #[ORM\ManyToMany(targetEntity: self::class)]
    #[ORM\JoinTable(
        name: 'station_correspondances',
        joinColumns: [new ORM\JoinColumn(name: 'station_id', referencedColumnName: 'id_Station')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'correspondance_id', referencedColumnName: 'id_Station')]
    )]
    private Collection $correspondances;


    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if (!$this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function __construct()
    {
        $this->correspondances = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id_Station;
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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getLine(): ?Line
    {
        return $this->line;
    }

    public function setLine(?Line $line): static
    {
        $this->line = $line;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCorrespondances(): Collection
    {
        return $this->correspondances;
    }

    public function addCorrespondance(self $station): static
    {
        if (!$this->correspondances->contains($station)) {
            $this->correspondances->add($station);
            $station->addCorrespondance($this); // symétrie
        }

        return $this;
    }
    public function removeCorrespondance(self $station): static
    {
        if ($this->correspondances->contains($station)) {
            $this->correspondances->removeElement($station);
            $station->removeCorrespondance($this); // symétrie
        }

        return $this;
    }
}

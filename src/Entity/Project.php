<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('project:read')]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Groups('project:read')]
    private ?string $nom = null;
    
    #[ORM\Column(type: Types::TEXT)]
    #[Groups('project:read')]
    private ?string $description = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('project:read')]
    private ?\DateTimeInterface $dateDebut = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('project:read')]
    private ?\DateTimeInterface $dateFin = null;
    
    #[ORM\Column(length: 255)]
    #[Groups('project:read')]
    private ?string $client = null;
    
    #[ORM\Column(length: 255)]
    #[Groups('project:read')]
    private ?string $statut = null;
    

    /**
     * @var Collection<int, Material>
     */
    #[ORM\OneToMany(targetEntity: Material::class, mappedBy: 'project')]
    private Collection $materials;

    public function __construct()
    {
        $this->materials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }


    /**
     * @return Collection<int, Material>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): static
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
            $material->setProject($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): static
    {
        if ($this->materials->removeElement($material)) {
            // set the owning side to null (unless already changed)
            if ($material->getProject() === $this) {
                $material->setProject(null);
            }
        }

        return $this;
    }
}

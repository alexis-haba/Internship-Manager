<?php
namespace App\Entity;

use App\Repository\OffreStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreStageRepository::class)]
class OffreStage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Entreprise::class, inversedBy: 'offres')]
    private $entreprise;

    #[ORM\Column(type: 'boolean')]
    private ?bool $validee = false;

    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: Candidature::class)]
    private $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    // Getters and setters...
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    public function isValidee(): ?bool
    {
        return $this->validee;
    }

    public function setValidee(bool $validee): self
    {
        $this->validee = $validee;
        return $this;
    }

    public function getCandidatures()
    {
        return $this->candidatures;
    }
}
<?php
namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[Vich\Uploadable]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'candidatures')]
    private $user;

    #[ORM\ManyToOne(targetEntity: OffreStage::class, inversedBy: 'candidatures')]
    private $offre;

    #[Vich\UploadableField(mapping: 'cv_files', fileNameProperty: 'cvFileName')]
    private ?File $cvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvFileName = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = 'en_attente';

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // Getters and setters...
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getOffre(): ?OffreStage
    {
        return $this->offre;
    }

    public function setOffre(?OffreStage $offre): self
    {
        $this->offre = $offre;
        return $this;
    }

    public function getCvFileName(): ?string
    {
        return $this->cvFileName;
    }

    public function setCvFileName(?string $cvFileName): self
    {
        $this->cvFileName = $cvFileName;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function setCvFile(?File $cvFile = null): void
    {
        $this->cvFile = $cvFile;
        if ($cvFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
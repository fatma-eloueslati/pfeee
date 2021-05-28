<?php

namespace App\Entity;

use App\Repository\CagnotteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CagnotteRepository::class)
 */
class Cagnotte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Beneficaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $Objectif;

    /**
     * @ORM\Column(type="date")
     */
    private $Deadline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getBeneficaire(): ?string
    {
        return $this->Beneficaire;
    }

    public function setBeneficaire(string $Beneficaire): self
    {
        $this->Beneficaire = $Beneficaire;

        return $this;
    }

    public function getObjectif(): ?int
    {
        return $this->Objectif;
    }

    public function setObjectif(int $Objectif): self
    {
        $this->Objectif = $Objectif;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->Deadline;
    }

    public function setDeadline(\DateTimeInterface $Deadline): self
    {
        $this->Deadline = $Deadline;

        return $this;
    }
}

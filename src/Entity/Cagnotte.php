<?php

namespace App\Entity;

use App\Repository\CagnotteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlphoto;

    /**
     * @ORM\Column(type="string")
     */
    private $Description;

    /**
     * @ORM\Column(type="string")
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

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="cagnotte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cagnotte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Virement::class, mappedBy="cagnotte")
     */
    private $virements;

    public function __construct()
    {
        $this->virements = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }
    public function getUrlphoto(): ?string
    {
        return $this->urlphoto;
    }
    public function setUrlphoto(string $urlphoto): self
    {
        $this->urlphoto = $urlphoto;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
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

    /**
     * @return Collection|Virement[]
     */
    public function getVirements(): Collection
    {
        return $this->virements;
    }

    public function addVirement(Virement $virement): self
    {
        if (!$this->virements->contains($virement)) {
            $this->virements[] = $virement;
            $virement->setCagnotte($this);
        }

        return $this;
    }

    public function removeVirement(Virement $virement): self
    {
        if ($this->virements->removeElement($virement)) {
            // set the owning side to null (unless already changed)
            if ($virement->getCagnotte() === $this) {
                $virement->setCagnotte(null);
            }
        }

        return $this;
    }
}

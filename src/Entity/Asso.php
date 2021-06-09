<?php

namespace App\Entity;

use App\Repository\AssoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssoRepository::class)
 */
class Asso
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumTel;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="asso")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity=Cagnotte::class, mappedBy="asso")
     */
    private $cagnotte;

    /**
     * @ORM\OneToMany(targetEntity=DonPhy::class, mappedBy="asso")
     */
    private $donphy;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->cagnotte = new ArrayCollection();
        $this->donphy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->NumTel;
    }

    public function setNumTel(int $NumTel): self
    {
        $this->NumTel = $NumTel;

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

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setAsso($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getAsso() === $this) {
                $event->setAsso(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cagnotte[]
     */
    public function getCagnotte(): Collection
    {
        return $this->cagnotte;
    }

    public function addCagnotte(Cagnotte $cagnotte): self
    {
        if (!$this->cagnotte->contains($cagnotte)) {
            $this->cagnotte[] = $cagnotte;
            $cagnotte->setAsso($this);
        }

        return $this;
    }

    public function removeCagnotte(Cagnotte $cagnotte): self
    {
        if ($this->cagnotte->removeElement($cagnotte)) {
            // set the owning side to null (unless already changed)
            if ($cagnotte->getAsso() === $this) {
                $cagnotte->setAsso(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DonPhy[]
     */
    public function getDonphy(): Collection
    {
        return $this->donphy;
    }

    public function addDonphy(DonPhy $donphy): self
    {
        if (!$this->donphy->contains($donphy)) {
            $this->donphy[] = $donphy;
            $donphy->setAsso($this);
        }

        return $this;
    }

    public function removeDonphy(DonPhy $donphy): self
    {
        if ($this->donphy->removeElement($donphy)) {
            // set the owning side to null (unless already changed)
            if ($donphy->getAsso() === $this) {
                $donphy->setAsso(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="category")
     */
    private $Event;

    /**
     * @ORM\OneToMany(targetEntity=DonPhy::class, mappedBy="category")
     */
    private $donphy;

    /**
     * @ORM\OneToMany(targetEntity=Cagnotte::class, mappedBy="category")
     */
    private $cagnotte;

    public function __construct()
    {
        $this->Event = new ArrayCollection();
        $this->donphy = new ArrayCollection();
        $this->cagnotte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->Event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->Event->contains($event)) {
            $this->Event[] = $event;
            $event->setCategory($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->Event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCategory() === $this) {
                $event->setCategory(null);
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
            $donphy->setCategory($this);
        }

        return $this;
    }

    public function removeDonphy(DonPhy $donphy): self
    {
        if ($this->donphy->removeElement($donphy)) {
            // set the owning side to null (unless already changed)
            if ($donphy->getCategory() === $this) {
                $donphy->setCategory(null);
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
            $cagnotte->setCategory($this);
        }

        return $this;
    }

    public function removeCagnotte(Cagnotte $cagnotte): self
    {
        if ($this->cagnotte->removeElement($cagnotte)) {
            // set the owning side to null (unless already changed)
            if ($cagnotte->getCategory() === $this) {
                $cagnotte->setCategory(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;


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
     * @ORM\OneToMany(targetEntity=Cagnotte::class, mappedBy="category")
     */
    private $cagnotte;
    

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->Event = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

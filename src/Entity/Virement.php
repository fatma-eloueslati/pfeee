<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VirementRepository::class)
 */
class Virement
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
    private $Date;
    /**
     * @ORM\Column(type="integer")
     */
    private $Amount;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Virement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity=Cagnotte::class, inversedBy="Virement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cagnotte;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

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
    public function getCagnotte(): ?Cagnotte
    {
        return $this->cagnotte;
    }

    public function setCagnotte(?Cagnotte $cagnotte): self
    {
        $this->cagnotte = $cagnotte;

        return $this;
    }
}

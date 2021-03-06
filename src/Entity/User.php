<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=DonPhy::class, mappedBy="user")
     */
    private $donphy;
    /**
     * @ORM\OneToMany(targetEntity=Virement::class, mappedBy="user")
     */
    private $virement;

    /**
     * @ORM\OneToMany(targetEntity=Cagnotte::class, mappedBy="user")
     */
    private $cagnotte;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;



    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;
    /**
     *  @ORM\OneToMany(targetEntity=Event::class, mappedBy="User")
     */
    private $events;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->donphy = new ArrayCollection();
        $this->cagnotte = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $donphy->setUser($this);
        }

        return $this;
    }

    public function removeDonphy(DonPhy $donphy): self
    {
        if ($this->donphy->removeElement($donphy)) {
            // set the owning side to null (unless already changed)
            if ($donphy->getUser() === $this) {
                $donphy->setUser(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Virement[]
     */
    public function getVirement(): Collection
    {
        return $this->virement;
    }

    public function addVirement(Virement $virement): self
    {
        if (!$this->virement->contains($virement)) {
            $this->virement[] = $virement;
            $virement->setUser($this);
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
            $cagnotte->setUser($this);
        }

        return $this;
    }

    public function removeCagnotte(Cagnotte $cagnotte): self
    {
        if ($this->cagnotte->removeElement($cagnotte)) {
            // set the owning side to null (unless already changed)
            if ($cagnotte->getUser() === $this) {
                $cagnotte->setUser(null);
            }
        }

        return $this;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return Collection|Event[]
     */

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}

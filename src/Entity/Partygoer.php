<?php

namespace App\Entity;

use App\Repository\PartygoerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartygoerRepository::class)
 */
class Partygoer
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;
    
    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="partygoer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="planner")
     */
    private $createdEvents;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author")
     */
    private $ownComments;

    public function __construct()
    {
        $this->createdEvents = new ArrayCollection();
        $this->ownComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getCreatedEvents(): Collection
    {
        return $this->createdEvents;
    }

    public function addCreatedEvent(Event $createdEvent): self
    {
        if (!$this->createdEvents->contains($createdEvent)) {
            $this->createdEvents[] = $createdEvent;
            $createdEvent->setOrganizer($this);
        }

        return $this;
    }

    public function removeCreatedEvent(Event $createdEvent): self
    {
        if ($this->createdEvents->removeElement($createdEvent)) {
            // set the owning side to null (unless already changed)
            if ($createdEvent->getOrganizer() === $this) {
                $createdEvent->setOrganizer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getOwnComments(): Collection
    {
        return $this->ownComments;
    }

    public function addOwnComment(Comment $ownComment): self
    {
        if (!$this->ownComments->contains($ownComment)) {
            $this->ownComments[] = $ownComment;
            $ownComment->setAuthor($this);
        }

        return $this;
    }

    public function removeOwnComment(Comment $ownComment): self
    {
        if ($this->ownComments->removeElement($ownComment)) {
            // set the owning side to null (unless already changed)
            if ($ownComment->getAuthor() === $this) {
                $ownComment->setAuthor(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvitationRepository::class)
 */
class Invitation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRequest;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMaking;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="invitationsRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partygoerGuest;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="invitationsMakings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partygoerEventPlanner;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="relatedInvitations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastModified;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAccepted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsRequest(): ?bool
    {
        return $this->isRequest;
    }

    public function setIsRequest(bool $isRequest): self
    {
        $this->isRequest = $isRequest;

        return $this;
    }

    public function getIsMaking(): ?bool
    {
        return $this->isMaking;
    }

    public function setIsMaking(bool $isMaking): self
    {
        $this->isMaking = $isMaking;

        return $this;
    }

    public function getPartygoerGuest(): ?Partygoer
    {
        return $this->partygoerGuest;
    }

    public function setPartygoerGuest(?Partygoer $partygoerGuest): self
    {
        $this->partygoerGuest = $partygoerGuest;

        return $this;
    }

    public function getPartygoerEventPlanner(): ?Partygoer
    {
        return $this->partygoerEventPlanner;
    }

    public function setPartygoerEventPlanner(?Partygoer $partygoerEventPlanner): self
    {
        $this->partygoerEventPlanner = $partygoerEventPlanner;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(?bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }
}

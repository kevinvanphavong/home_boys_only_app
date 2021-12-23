<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="conversationsAsPlanner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userPlanner;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="conversationsAsGuest")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userGuest;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $party;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation")
     */
    private $messages;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastMessageDate;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPlanner(): ?Partygoer
    {
        return $this->userPlanner;
    }

    public function setUserPlanner(?Partygoer $userPlanner): self
    {
        $this->userPlanner = $userPlanner;

        return $this;
    }

    public function getUserGuest(): ?Partygoer
    {
        return $this->userGuest;
    }

    public function setUserGuest(?Partygoer $userGuest): self
    {
        $this->userGuest = $userGuest;

        return $this;
    }

    public function getParty(): ?Event
    {
        return $this->party;
    }

    public function setParty(?Event $party): self
    {
        $this->party = $party;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }

        return $this;
    }

    public function getLastMessageDate(): ?\DateTimeInterface
    {
        return $this->lastMessageDate;
    }

    public function setLastMessageDate(): ?self
    {
        $this->lastMessageDate = new DateTime();

        return $this;
    }
}

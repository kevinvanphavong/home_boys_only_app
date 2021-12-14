<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PartygoerRepository::class)
 * @Vich\Uploadable 
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

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userPlanner")
     */
    private $conversationsAsPlanner;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userGuest")
     */
    private $conversationsAsGuest;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="author")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="author")
     */
    private $notificationsAsPlanner;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="recipient")
     */
    private $notificationsAsGuest;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class)
     */
    private $favlistParties;

    /**
     * @ORM\OneToOne(targetEntity=ProfileImage::class, mappedBy="partygoer", cascade={"persist", "remove"})
     */
    private $profileImage;

    public function __construct()
    {
        $this->createdEvents = new ArrayCollection();
        $this->ownComments = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->notificationsAsGuest = new ArrayCollection();
        $this->favlistParties = new ArrayCollection();
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
            $createdEvent->setPlanner($this);
        }

        return $this;
    }

    public function removeCreatedEvent(Event $createdEvent): self
    {
        if ($this->createdEvents->removeElement($createdEvent)) {
            // set the owning side to null (unless already changed)
            if ($createdEvent->getPlanner() === $this) {
                $createdEvent->setPlanner(null);
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

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsAsPlanner(): Collection
    {
        return $this->conversationsAsPlanner;
    }

    public function addConversationAsPlanner(Conversation $conversation): self
    {
        if (!$this->conversationsAsPlanner->contains($conversation)) {
            $this->conversationsAsPlanner[] = $conversation;
            $conversation->setUserPlanner($this);
        }

        return $this;
    }

    public function removeConversationAsPlanner(Conversation $conversation): self
    {
        if ($this->conversationsAsPlanner->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getUserPlanner() === $this) {
                $conversation->setUserPlanner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsAsGuest(): Collection
    {
        return $this->conversationsAsGuest;
    }

    public function addConversationAsGuest(Conversation $conversation): self
    {
        if (!$this->conversationsAsGuest->contains($conversation)) {
            $this->conversationsAsGuest[] = $conversation;
            $conversation->setUserPlanner($this);
        }

        return $this;
    }

    public function removeConversationAsGuest(Conversation $conversation): self
    {
        if ($this->conversationsAsGuest->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getUserPlanner() === $this) {
                $conversation->setUserPlanner(null);
            }
        }

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
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotificationsAsGuest(): Collection
    {
        return $this->notificationsAsGuest;
    }

    public function addNotificationsAsGuest(Notification $notificationsAsGuest): self
    {
        if (!$this->notificationsAsGuest->contains($notificationsAsGuest)) {
            $this->notificationsAsGuest[] = $notificationsAsGuest;
            $notificationsAsGuest->setAuthor($this);
        }

        return $this;
    }

    public function removeNotificationsAsGuest(Notification $notificationsAsGuest): self
    {
        if ($this->notificationsAsGuest->removeElement($notificationsAsGuest)) {
            // set the owning side to null (unless already changed)
            if ($notificationsAsGuest->getAuthor() === $this) {
                $notificationsAsGuest->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getFavlistParties(): Collection
    {
        return $this->favlistParties;
    }

    public function addFavlistParty(Event $favlistParty): self
    {
        if (!$this->favlistParties->contains($favlistParty)) {
            $this->favlistParties[] = $favlistParty;
        }

        return $this;
    }

    public function removeFavlistParty(Event $favlistParty): self
    {
        $this->favlistParties->removeElement($favlistParty);

        return $this;
    }

    public function checkPartyInFavlist(Event $event): bool
    {
        return $this->favlistParties->contains($event);
    }

    public function getProfileImage(): ?ProfileImage
    {
        return $this->profileImage;
    }

    public function setProfileImage(ProfileImage $profileImage): self
    {
        // set the owning side of the relation if necessary
        if ($profileImage->getPartygoer() !== $this) {
            $profileImage->setPartygoer($this);
        }

        $this->profileImage = $profileImage;

        return $this;
    }
}

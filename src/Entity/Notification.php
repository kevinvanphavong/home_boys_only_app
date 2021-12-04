<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
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
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="notificationsAsPlanner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Partygoer::class, inversedBy="notificationsAsGuest")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthor(): ?Partygoer
    {
        return $this->author;
    }

    public function setAuthor(?Partygoer $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRecipient(): ?Partygoer
    {
        return $this->recipient;
    }

    public function setRecipient(?Partygoer $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}

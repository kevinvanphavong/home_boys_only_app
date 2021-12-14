<?php

namespace App\Entity;

use App\Repository\ProfileImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileImageRepository::class)
 */
class ProfileImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Partygoer::class, inversedBy="profileImage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partygoer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPartygoer(): ?Partygoer
    {
        return $this->partygoer;
    }

    public function setPartygoer(Partygoer $partygoer): self
    {
        $this->partygoer = $partygoer;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\GatheringComplementToBringRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GatheringComplementToBringRepository::class)
 */
class GatheringComplementToBring
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="gatheringComplementsToBring")
     */
    private $eventsWithComplementsToBring;

    public function __construct()
    {
        $this->eventsWithComplementsToBring = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventsWithComplementsToBring(): Collection
    {
        return $this->eventsWithComplementsToBring;
    }

    public function addEventsWithComplementsToBring(Event $eventsWithComplementsToBring): self
    {
        if (!$this->eventsWithComplementsToBring->contains($eventsWithComplementsToBring)) {
            $this->eventsWithComplementsToBring[] = $eventsWithComplementsToBring;
        }

        return $this;
    }

    public function removeEventsWithComplementsToBring(Event $eventsWithComplementsToBring): self
    {
        $this->eventsWithComplementsToBring->removeElement($eventsWithComplementsToBring);

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\GatheringComplementIncludedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GatheringComplementIncludedRepository::class)
 */
class GatheringComplementIncluded
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
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="gatheringComplementsIncluded")
     */
    private $eventsWithComplementIncluded;

    public function __construct()
    {
        $this->eventsWithComplementIncluded = new ArrayCollection();
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
    public function getEventsWithComplementIncluded(): Collection
    {
        return $this->eventsWithComplementIncluded;
    }

    public function addEventsWithComplementIncluded(Event $eventsWithComplementIncluded): self
    {
        if (!$this->eventsWithComplementIncluded->contains($eventsWithComplementIncluded)) {
            $this->eventsWithComplementIncluded[] = $eventsWithComplementIncluded;
        }

        return $this;
    }

    public function removeEventsWithComplementIncluded(Event $eventsWithComplementIncluded): self
    {
        $this->eventsWithComplementIncluded->removeElement($eventsWithComplementIncluded);

        return $this;
    }
}

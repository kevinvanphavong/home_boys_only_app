<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $startingDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endingDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entrancePrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endOfRegistrations;

    /**
     * @ORM\Column(type="integer")
     */
    private $limitedPlaces;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="event")
     */
    private $relatedComments;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\ManyToMany(targetEntity=GatheringComplementIncluded::class, mappedBy="eventsWithComplementIncluded")
     */
    private $gatheringComplementsIncluded;

    /**
     * @ORM\ManyToMany(targetEntity=GatheringComplementToBring::class, mappedBy="eventsWithComplementsToBring")
     */
    private $gatheringComplementsToBring;

    /**
     * @ORM\OneToMany(targetEntity=EventPicture::class, mappedBy="event", cascade={"persist"})
     */
    private $eventPictures;

    public function __construct()
    {
        $this->relatedComments = new ArrayCollection();
        $this->gatheringComplementsIncluded = new ArrayCollection();
        $this->gatheringComplementsToBring = new ArrayCollection();
        $this->eventPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->endingDate;
    }

    public function setEndingDate(\DateTimeInterface $endingDate): self
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    public function getPlanner(): ?User
    {
        return $this->planner;
    }

    public function setPlanner(?User $planner): self
    {
        $this->planner = $planner;

        return $this;
    }

    public function getEntrancePrice(): ?int
    {
        return $this->entrancePrice;
    }

    public function setEntrancePrice(?int $entrancePrice): self
    {
        $this->entrancePrice = $entrancePrice;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEndOfRegistrations(): ?\DateTimeInterface
    {
        return $this->endOfRegistrations;
    }

    public function setEndOfRegistrations(\DateTimeInterface $endOfRegistrations): self
    {
        $this->endOfRegistrations = $endOfRegistrations;

        return $this;
    }

    public function getLimitedPlaces(): ?int
    {
        return $this->limitedPlaces;
    }

    public function setLimitedPlaces(int $limitedPlaces): self
    {
        $this->limitedPlaces = $limitedPlaces;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getRelatedComments(): Collection
    {
        return $this->relatedComments;
    }

    public function addRelatedComment(Comment $relatedComment): self
    {
        if (!$this->relatedComments->contains($relatedComment)) {
            $this->relatedComments[] = $relatedComment;
            $relatedComment->setEvent($this);
        }

        return $this;
    }

    public function removeRelatedComment(Comment $relatedComment): self
    {
        if ($this->relatedComments->removeElement($relatedComment)) {
            // set the owning side to null (unless already changed)
            if ($relatedComment->getEvent() === $this) {
                $relatedComment->setEvent(null);
            }
        }

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * @return Collection|GatheringComplementIncluded[]
     */
    public function getGatheringComplementsIncluded(): Collection
    {
        return $this->gatheringComplementsIncluded;
    }

    public function addGatheringComplementsIncluded(GatheringComplementIncluded $gatheringComplementsIncluded): self
    {
        if (!$this->gatheringComplementsIncluded->contains($gatheringComplementsIncluded)) {
            $this->gatheringComplementsIncluded[] = $gatheringComplementsIncluded;
            $gatheringComplementsIncluded->addEventsWithComplementIncluded($this);
        }

        return $this;
    }

    public function removeGatheringComplementsIncluded(GatheringComplementIncluded $gatheringComplementsIncluded): self
    {
        if ($this->gatheringComplementsIncluded->removeElement($gatheringComplementsIncluded)) {
            $gatheringComplementsIncluded->removeEventsWithComplementIncluded($this);
        }

        return $this;
    }

    /**
     * @return Collection|GatheringComplementToBring[]
     */
    public function getGatheringComplementsToBring(): Collection
    {
        return $this->gatheringComplementsToBring;
    }

    public function addGatheringComplementsToBring(GatheringComplementToBring $gatheringComplementsToBring): self
    {
        if (!$this->gatheringComplementsToBring->contains($gatheringComplementsToBring)) {
            $this->gatheringComplementsToBring[] = $gatheringComplementsToBring;
            $gatheringComplementsToBring->addEventsWithComplementsToBring($this);
        }

        return $this;
    }

    public function removeGatheringComplementsToBring(GatheringComplementToBring $gatheringComplementsToBring): self
    {
        if ($this->gatheringComplementsToBring->removeElement($gatheringComplementsToBring)) {
            $gatheringComplementsToBring->removeEventsWithComplementsToBring($this);
        }

        return $this;
    }

    /**
     * @return Collection|EventPicture[]
     */
    public function getEventPictures(): Collection
    {
        return $this->eventPictures;
    }

    public function addEventPicture(EventPicture $eventPicture): self
    {
        if (!$this->eventPictures->contains($eventPicture)) {
            $this->eventPictures[] = $eventPicture;
            $eventPicture->setEvent($this);
        }

        return $this;
    }

    public function removeEventPicture(EventPicture $eventPicture): self
    {
        if ($this->eventPictures->removeElement($eventPicture)) {
            // set the owning side to null (unless already changed)
            if ($eventPicture->getEvent() === $this) {
                $eventPicture->setEvent(null);
            }
        }

        return $this;
    }
}

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
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Renseignez l'intitulé")
     * @ORM\Column(type="string", length=255)
     */
    private $nameEvent;

    /**
     * @Assert\NotBlank(message="Renseignez la date et l'heure de début")
     * @ORM\Column(type="datetime")
     */
    private $StartDateTime;

    /**
     * @Assert\NotBlank(message="Renseignez la durée")
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @Assert\NotBlank(message="Renseignez la date limite d'inscription")
     * @ORM\Column(type="datetime")
     */
    private $registrationDeadLine;

    /**
     * @Assert\NotBlank(message="Renseignez le nombre max de participants")
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $nbRegistrationsMax;

    /**
     * @Assert\NotBlank(message="Renseignez la description")
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoEvent;


    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="events")
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="event")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="inscription")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="planner")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="event")
     */
    private $campus;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getNameEvent()
    {
        return $this->nameEvent;
    }

    /**
     * @param mixed $nameEvent
     */
    public function setNameEvent($nameEvent): void
    {
        $this->nameEvent = $nameEvent;
    }

    /**
     * @return mixed
     */
    public function getStartDateTime()
    {
        return $this->StartDateTime;
    }

    /**
     * @param mixed $StartDateTime
     */
    public function setStartDateTime($StartDateTime): void
    {
        $this->StartDateTime = $StartDateTime;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getRegistrationDeadLine()
    {
        return $this->registrationDeadLine;
    }

    /**
     * @param mixed $registrationDeadLine
     */
    public function setRegistrationDeadLine($registrationDeadLine): void
    {
        $this->registrationDeadLine = $registrationDeadLine;
    }

    /**
     * @return mixed
     */
    public function getNbRegistrationsMax()
    {
        return $this->nbRegistrationsMax;
    }

    /**
     * @param mixed $nbRegistrationsMax
     */
    public function setNbRegistrationsMax($nbRegistrationsMax): void
    {
        $this->nbRegistrationsMax = $nbRegistrationsMax;
    }

    /**
     * @return mixed
     */
    public function getInfoEvent()
    {
        return $this->infoEvent;
    }

    /**
     * @param mixed $infoEvent
     */
    public function setInfoEvent($infoEvent): void
    {
        $this->infoEvent = $infoEvent;
    }


    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this-> status = $status;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addInscription($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeInscription($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }





}

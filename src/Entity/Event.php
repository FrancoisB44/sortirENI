<?php

namespace App\Entity;

use App\Repository\EventRepository;
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
     * @Assert\NotBlank(message="Renseignez le status (ouvert, archivé, etc")
     * @ORM\Column(type="string", length=255)
     */
    private $status;

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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }




}

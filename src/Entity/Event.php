<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="string", length=255)
     */
    private $idEvent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameEvent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $StartDateTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDeadLine;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $nbRegistrationsMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoEvent;

    /**
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
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param mixed $idEvent
     */
    public function setIdEvent($idEvent): void
    {
        $this->idEvent = $idEvent;
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

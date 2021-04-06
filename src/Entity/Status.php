<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
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
    private $wording;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $idStatus
     */
    public function setIdStatus($idStatus): void
    {
        $this->idStatus = $idStatus;
    }

    /**
     * @return mixed
     */
    public function getWording()
    {
        return $this->wording;
    }

    /**
     * @param mixed $wording
     */
    public function setWording($wording): void
    {
        $this->wording = $wording;
    }




}

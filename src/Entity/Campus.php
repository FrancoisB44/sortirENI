<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 */
class Campus
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
    private $idCampus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameCampus;

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
    public function getIdCampus()
    {
        return $this->idCampus;
    }

    /**
     * @param mixed $idCampus
     */
    public function setIdCampus($idCampus): void
    {
        $this->idCampus = $idCampus;
    }

    /**
     * @return mixed
     */
    public function getNameCampus()
    {
        return $this->nameCampus;
    }

    /**
     * @param mixed $nameCampus
     */
    public function setNameCampus($nameCampus): void
    {
        $this->nameCampus = $nameCampus;
    }



}

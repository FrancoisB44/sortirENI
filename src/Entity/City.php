<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class City
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
    private $idVille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomVille;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=0)
     */
    private $codePostal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVille(): ?string
    {
        return $this->idVille;
    }

    public function setIdVille(string $idVille): self
    {
        $this->idVille = $idVille;

        return $this;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"pseudo"}, message="There is already an account with this pseudo")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column (type="string", length=100)
     * @Assert\NotBlank(message="Veuillez renseigner un pseudo")
     */
    private $pseudo;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un nom ")
     */
    private $nameUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un prénom")
     */
    private $firstNameUser;

    /**
     * @ORM\Column(type="string",  nullable=true)
     * @Assert\NotBlank(message="Veuillez renseigner un numéro de téléphone")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=13, length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un mail")
     * @Assert\Email(message="Votre mail doit respecter le format xxx@xxx.com")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="users")
     */
    private $inscription;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="user")
     */
    private $planner;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="users")
     */
    private $campus;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $pictureName;


    public function __construct()
    {
        $this->inscription = new ArrayCollection();
        $this->planner = new ArrayCollection();
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
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getNameUser()
    {
        return $this->nameUser;
    }

    /**
     * @param mixed $nameUser
     */
    public function setNameUser($nameUser): void
    {
        $this->nameUser = $nameUser;
    }

    /**
     * @return mixed
     */
    public function getFirstNameUser()
    {
        return $this->firstNameUser;
    }

    /**
     * @param mixed $firstNameUser
     */
    public function setFirstNameUser($firstNameUser): void
    {
        $this->firstNameUser = $firstNameUser;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     * @see UserInterface
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        {
            $roles = $this->roles;
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_DISABLED';// on ajoute le role user ds le tableau de roles et un retourne ce tab avc la nvlle valeur
            return array_unique($roles);
        }
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
//    public function getUsername()
//    {
//
//    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return (string)$this->pseudo;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function __toString()
    {
        return $this->pseudo;
    }

    /**
     * @return Collection|Event[]
     */
    public function getInscription(): Collection
    {
        return $this->inscription;
    }

    public function addInscription(Event $inscription): self
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription[] = $inscription;
        }

        return $this;
    }

    public function removeInscription(Event $inscription): self
    {
        $this->inscription->removeElement($inscription);

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getPlanner(): Collection
    {
        return $this->planner;
    }

    public function addPlanner(Event $planner): self
    {
        if (!$this->planner->contains($planner)) {
            $this->planner[] = $planner;
            $planner->setUser($this);
        }

        return $this;
    }

    public function removePlanner(Event $planner): self
    {
        if ($this->planner->removeElement($planner)) {
            // set the owning side to null (unless already changed)
            if ($planner->getUser() === $this) {
                $planner->setUser(null);
            }
        }

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

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }

}

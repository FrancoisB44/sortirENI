<?php
//
//namespace App\Entity;
//
//use App\Repository\CityRepository;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * @ORM\Entity(repositoryClass=CityRepository::class)
// */
//class City
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $nameCity;
//
//    /**
//     * @ORM\Column(type="decimal", precision=5, scale=0)
//     */
//    private $zipCode;
//
//    /**
//     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="city")
//     */
//    private $places;
//
//    public function __construct()
//    {
//        $this->places = new ArrayCollection();
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * @param mixed $id
//     */
//    public function setId($id): void
//    {
//        $this->id = $id;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getNameCity()
//    {
//        return $this->nameCity;
//    }
//
//    /**
//     * @param mixed $nameCity
//     */
//    public function setNameCity($nameCity): void
//    {
//        $this->nameCity = $nameCity;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getZipCode()
//    {
//        return $this->zipCode;
//    }
//
//    /**
//     * @param mixed $zipCode
//     */
//    public function setZipCode($zipCode): void
//    {
//        $this->zipCode = $zipCode;
//    }
//
//    /**
//     * @return Collection|Place[]
//     */
//    public function getPlaces(): Collection
//    {
//        return $this->places;
//    }
//
//    public function addPlace(Place $place): self
//    {
//        if (!$this->places->contains($place)) {
//            $this->places[] = $place;
//            $place->setCity($this);
//        }
//
//        return $this;
//    }
//
//    public function removePlace(Place $place): self
//    {
//        if ($this->places->removeElement($place)) {
//            // set the owning side to null (unless already changed)
//            if ($place->getCity() === $this) {
//                $place->setCity(null);
//            }
//        }
//
//        return $this;
//    }
//
//    public function __toString()
//    {
//        return $this->nameCity;
//    }
//
//
//}

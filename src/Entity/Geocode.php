<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Geocode
 *
 * @ORM\Table(name="geocode")
 * @ORM\Entity
 */
class Geocode
{
    /**
     * @var int
     *
     * @ORM\Column(name="idgeo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idgeo;

    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="Latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="Longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    public function getIdgeo(): ?int
    {
        return $this->idgeo;
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }


}

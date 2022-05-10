<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_delivery", columns={"idlivreur"})})
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_livraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups ("post:read")
     */
    private $idLivraison;

    /**
     * @var int
     *
     * @ORM\Column(name="reflivraison", type="integer", nullable=true)
     * @Groups ("post:read")
     */
    private $reflivraison;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable (on="create")
     * @ORM\Column(name="date", type="datetime", nullable=true)
     * @Groups ("post:read")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=true, options={"default"="en cours"})
     * @Groups ("post:read")
     */
    private $etat = 'en cours';

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     * @Groups ("post:read")
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="rueliv", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $rueliv;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=255, nullable=true)
     * @Groups ("post:read")
     */
    private $client;

    /**
     * @var \Delivery
     *
     * @ORM\ManyToOne(targetEntity="Delivery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlivreur", referencedColumnName="id")
     * })
     */
    private $idlivreur;

    public function getIdLivraison(): ?int
    {
        return $this->idLivraison;
    }

    public function getReflivraison(): ?int
    {
        return $this->reflivraison;
    }

    public function setReflivraison(int $reflivraison): self
    {
        $this->reflivraison = $reflivraison;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRueliv(): ?string
    {
        return $this->rueliv;
    }

    public function setRueliv(string $rueliv): self
    {
        $this->rueliv = $rueliv;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getIdlivreur(): ?Delivery
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?Delivery $idlivreur): self
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }


}

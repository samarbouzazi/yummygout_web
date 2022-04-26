<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fffkkkkidplat", columns={"idplat"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="Idpanier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"paniers"})

     */
    private $idpanier;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Groups({"paniers"})

     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=255, nullable=false)
     * @Groups({"paniers"})
     */
    private $client;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer", nullable=false)
     * @Groups({"paniers"})
     */
    private $total;

    /**
     * @var \Platt
     *
     * @ORM\ManyToOne(targetEntity="Platt")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplat", referencedColumnName="Idplat")
     * })
     * @Groups({"paniers"})
     */
    private $idplat;

    public function getIdpanier(): ?int
    {
        return $this->idpanier;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIdplat(): ?Platt
    {
        return $this->idplat;
    }

    public function setIdplat(?Platt $idplat): self
    {
        $this->idplat = $idplat;

        return $this;
    }



}

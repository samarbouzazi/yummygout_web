<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lignecommande
 *
 * @ORM\Table(name="lignecommande", indexes={@ORM\Index(name="idclientt", columns={"id_client"}), @ORM\Index(name="FK_853B7939F3F753A7", columns={"idplat"}), @ORM\Index(name="FK_853B7939B907C208", columns={"Idpanier"})})
 * @ORM\Entity
 */
class Lignecommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idlc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlc;

    /**
     * @var \Panier
     *
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Idpanier", referencedColumnName="Idpanier")
     * })
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     */
    private $idpanier;

    /**
     * @var \Platt
     *
     * @ORM\ManyToOne(targetEntity="Platt")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplat", referencedColumnName="Idplat")
     * })
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     */
    private $idplat;

    /**
     * @var \Clientinfo
     *
     * @ORM\ManyToOne(targetEntity="Clientinfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     */
    private $idClient;

    public function getIdlc(): ?int
    {
        return $this->idlc;
    }

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): self
    {
        $this->idpanier = $idpanier;

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

    public function getIdClient(): ?Clientinfo
    {
        return $this->idClient;
    }

    public function setIdClient(?Clientinfo $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }


}

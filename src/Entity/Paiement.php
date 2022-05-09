<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="fkkkkkkkkkid_client", columns={"id_client"}), @ORM\Index(name="fkkkIdpanier", columns={"Idpanier"})})
 * @ORM\Entity
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idpaiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="etatpaiement", type="string", length=255, nullable=false, options={"default"="non"})
     */
    private $etatpaiement = 'non';

    /**
     * @var \Clientinfo
     *
     * @ORM\ManyToOne(targetEntity="Clientinfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $idClient;

    /**
     * @var \Panier
     *
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Idpanier", referencedColumnName="Idpanier")
     * })
     */
    private $idpanier;

    public function getIdpaiement(): ?int
    {
        return $this->idpaiement;
    }

    public function getEtatpaiement(): ?string
    {
        return $this->etatpaiement;
    }

    public function setEtatpaiement(string $etatpaiement): self
    {
        $this->etatpaiement = $etatpaiement;

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

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): self
    {
        $this->idpanier = $idpanier;

        return $this;
    }


}

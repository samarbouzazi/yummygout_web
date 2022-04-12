<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="fkkkIdpanier", columns={"Idpanier"}), @ORM\Index(name="fkkkkkkkkkid_client", columns={"id_client"})})
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
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     */
    private $etatpaiement = 'non';

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
     * @var \Clientinfo
     *
     * @ORM\ManyToOne(targetEntity="Clientinfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     */
    private $idClient;

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

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): self
    {
        $this->idpanier = $idpanier;

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

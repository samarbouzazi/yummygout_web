<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="idplat", columns={"idplat"}), @ORM\Index(name="id_client", columns={"id_client"})})
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
     */
    private $idpanier;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     *  @Assert\Positive
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="numfacture", type="string", length=255, nullable=false)
     */
    private $numfacture;

    /**
     * @var string
     *
     * @ORM\Column(name="Rue", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     * @Assert\Length(
     *      min = 4,
     *     max= 30,
     *     minMessage = "le nombre de caractére doit étre supérieur à 4",
     *     maxMessage= "doit étre inférieur à 30"
     * )
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     * @Assert\Length(
     *      min = 4,
     *     max= 10,
     *     minMessage = "le nombre de caractére doit étre supérieur à 4",
     *     maxMessage= "doit étre inférieur à 10"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" cannot contain a number"
     * )
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="Delegation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le champ doit étre non vide")
     * @Assert\Length(
     *      min = 4,
     *     max= 15,
     *     minMessage = "le nombre de caractére doit étre supérieur à 4",
     *     maxMessage= "doit étre inférieur à 15"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="cannot contain a number"
     * )
     */
    private $delegation;

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

    public function getNumfacture(): ?string
    {
        return $this->numfacture;
    }

    public function setNumfacture(string $numfacture): self
    {
        $this->numfacture = $numfacture;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

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

    public function getDelegation(): ?string
    {
        return $this->delegation;
    }

    public function setDelegation(string $delegation): self
    {
        $this->delegation = $delegation;

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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="fk_pan", columns={"Idpanier"}), @ORM\Index(name="FK_A60C9F1F347E1C03", columns={"idlivreur"})})
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
     */
    private $idLivraison;

    /**
     * @var int
     *
     * @ORM\Column(name="reflivraison", type="integer", nullable=false)
     */
    private $reflivraison;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable (on="create")
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false, options={"default"="en cours"})
     */
    private $etat = 'en cours';

    /**
     * @var \Panier
     * @Assert\NotBlank (message ="Choisir un numéro de panier")
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Idpanier", referencedColumnName="Idpanier")
     * })
     */
    private $idpanier;

    /**
     * @var \Livreur
     * @Assert\NotBlank (message ="Choisir un livreur")
     * @ORM\ManyToOne(targetEntity="Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlivreur", referencedColumnName="idlivreur")
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

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): self
    {
        $this->idpanier = $idpanier;

        return $this;
    }

    public function getIdlivreur(): ?Livreur
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?Livreur $idlivreur): self
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }


}

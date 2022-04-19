<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Stocks
 *
 * @ORM\Table(name="stocks", indexes={@ORM\Index(name="fk_idf", columns={"idf"})})
 * @ORM\Entity
 */
class Stocks
{
    /**
     * @var int
     *
     * @ORM\Column(name="ids", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ids;

    /**
     * @var string
     *
     * @ORM\Column(name="noms", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="nom est obligatoire")
     * @Groups("post:read")
     */
    private $noms;

    /**
     * @var \DateTime
     * @Assert\Date
     *
     * @ORM\Column(name="date_ajout_s", type="date", nullable=false)
     * @Assert\NotBlank(message="date est obligatoire")
     * @Assert\GreaterThanOrEqual("today",message="La date d'ajout doit être supérieure à la date d'aujourd'hui"))
     */
    private $dateAjoutS;

    /**
     * @var \DateTime
     * @Assert\Date
     *
     * @ORM\Column(name="date_fin_s", type="date", nullable=false)
     * @Assert\NotBlank(message="date est obligatoire")
     * @Assert\GreaterThan(propertyPath="dateAjoutS",
    message="La date du fin doit être supérieure à la date début")
     */
    private $dateFinS;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_s", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="prix est obligatoire")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups("post:read")
     */
    private $prixS;

    /**
     * @var int
     *
     * @ORM\Column(name="qt_s", type="integer", nullable=false)
     * @Assert\NotBlank(message="quantité est obligatoire")
     */
    private $qtS;

    /**
     * @var \Fournisseurs
     *
     * @ORM\ManyToOne(targetEntity="Fournisseurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idf", referencedColumnName="idf")
     * })
     * @Assert\NotBlank(message="fournisseur est obligatoire")
     */
    private $idf;

    public function getIds(): ?int
    {
        return $this->ids;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getDateAjoutS(): ?\DateTimeInterface
    {
        return $this->dateAjoutS;
    }

    public function setDateAjoutS(\DateTimeInterface $dateAjoutS): self
    {
        $this->dateAjoutS = $dateAjoutS;

        return $this;
    }

    public function getDateFinS(): ?\DateTimeInterface
    {
        return $this->dateFinS;
    }

    public function setDateFinS(\DateTimeInterface $dateFinS): self
    {
        $this->dateFinS = $dateFinS;

        return $this;
    }

    public function getPrixS(): ?float
    {
        return $this->prixS;
    }

    public function setPrixS(float $prixS): self
    {
        $this->prixS = $prixS;

        return $this;
    }

    public function getQtS(): ?int
    {
        return $this->qtS;
    }

    public function setQtS(int $qtS): self
    {
        $this->qtS = $qtS;

        return $this;
    }

    public function getIdf(): ?Fournisseurs
    {
        return $this->idf;
    }

    public function setIdf(?Fournisseurs $idf): self
    {
        $this->idf = $idf;

        return $this;
    }


}

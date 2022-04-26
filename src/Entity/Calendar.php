<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendar
 *
 * @ORM\Table(name="calendar", indexes={@ORM\Index(name="FK_6EA9A146D81736EA", columns={"idlivraison"})})
 * @ORM\Entity
 */
class Calendar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=false)
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="allday", type="boolean", nullable=false)
     */
    private $allday;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundcolor", type="string", length=255, nullable=false)
     */
    private $backgroundcolor;

    /**
     * @var string
     *
     * @ORM\Column(name="bordercolor", type="string", length=7, nullable=false)
     */
    private $bordercolor;

    /**
     * @var string
     *
     * @ORM\Column(name="textcolor", type="string", length=7, nullable=false)
     */
    private $textcolor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="livreur", type="string", length=255, nullable=true)
     */
    private $livreur;

    /**
     * @var \Livraison
     *
     * @ORM\ManyToOne(targetEntity="Livraison")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlivraison", referencedColumnName="id_livraison")
     * })
     */
    private $idlivraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAllday(): ?bool
    {
        return $this->allday;
    }

    public function setAllday(bool $allday): self
    {
        $this->allday = $allday;

        return $this;
    }

    public function getBackgroundcolor(): ?string
    {
        return $this->backgroundcolor;
    }

    public function setBackgroundcolor(string $backgroundcolor): self
    {
        $this->backgroundcolor = $backgroundcolor;

        return $this;
    }

    public function getBordercolor(): ?string
    {
        return $this->bordercolor;
    }

    public function setBordercolor(string $bordercolor): self
    {
        $this->bordercolor = $bordercolor;

        return $this;
    }

    public function getTextcolor(): ?string
    {
        return $this->textcolor;
    }

    public function setTextcolor(string $textcolor): self
    {
        $this->textcolor = $textcolor;

        return $this;
    }

    public function getLivreur(): ?string
    {
        return $this->livreur;
    }

    public function setLivreur(?string $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getIdlivraison(): ?Livraison
    {
        return $this->idlivraison;
    }

    public function setIdlivraison(?Livraison $idlivraison): self
    {
        $this->idlivraison = $idlivraison;

        return $this;
    }


}

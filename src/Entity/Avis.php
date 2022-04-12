<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="fk_idblog", columns={"idblog"}), @ORM\Index(name="fk_idc", columns={"id_client"})})
 * @ORM\Entity
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="idavis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idavis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateavis", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $dateavis;

    /**
     * @var int
     *
     * @ORM\Column(name="likee", type="integer", nullable=false)
     */
    private $likee;

    /**
     * @var int
     *
     * @ORM\Column(name="deslike", type="integer", nullable=false)
     */
    private $deslike;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionavis", type="string", length=250, nullable=false)
     * * @Assert\NotBlank(message="av is required")
     */
    private $descriptionavis;

    /**
     * @var \Blog
     *
     * @ORM\ManyToOne(targetEntity="Blog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idblog", referencedColumnName="Idblog")
     * })
     */
    private $idblog;

    /**
     * @var \Clientinfo
     *
     * @ORM\ManyToOne(targetEntity="Clientinfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $id_client;

    public function getIdavis(): ?int
    {
        return $this->idavis;
    }

    public function getDateavis(): ?\DateTimeInterface
    {
        return $this->dateavis;
    }

    public function setDateavis(\DateTimeInterface $dateavis): self
    {
        $this->dateavis = $dateavis;

        return $this;
    }

    public function getLikee(): ?int
    {
        return $this->likee;
    }

    public function setLikee(int $likee): self
    {
        $this->likee = $likee;

        return $this;
    }

    public function getDeslike(): ?int
    {
        return $this->deslike;
    }

    public function setDeslike(int $deslike): self
    {
        $this->deslike = $deslike;

        return $this;
    }

    public function getDescriptionavis(): ?string
    {
        return $this->descriptionavis;
    }

    public function setDescriptionavis(string $descriptionavis): self
    {
        $this->descriptionavis = $descriptionavis;

        return $this;
    }

    public function getIdblog(): ?Blog
    {
        return $this->idblog;
    }

    public function setIdblog(?Blog $idblog): self
    {
        $this->idblog = $idblog;

        return $this;
    }

    public function getIdClient(): ?Clientinfo
    {
        return $this->id_client;
    }

    public function setIdClient(?Clientinfo $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }


}

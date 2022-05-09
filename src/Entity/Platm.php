<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Platm
 *
 * @ORM\Table(name="platm")
 * @ORM\Entity
 */
class Platm
{
    /**
     * @var int
     *
     * @ORM\Column(name="Idplat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplat;

    /**
     * @var string
     *
     * @ORM\Column(name="Descplat", type="string", length=255, nullable=false)
     */
    private $descplat;

    /**
     * @var string
     *
     * @ORM\Column(name="Nomplat", type="string", length=255, nullable=false)
     */
    private $nomplat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_plat", type="integer", nullable=false)
     */
    private $prixPlat;

    /**
     * @var int
     *
     * @ORM\Column(name="q_plat", type="integer", nullable=false)
     */
    private $qPlat;

    /**
     * @var bool
     *
     * @ORM\Column(name="stock", type="boolean", nullable=false)
     */
    private $stock;

    public function getIdplat(): ?int
    {
        return $this->idplat;
    }

    public function getDescplat(): ?string
    {
        return $this->descplat;
    }

    public function setDescplat(string $descplat): self
    {
        $this->descplat = $descplat;

        return $this;
    }

    public function getNomplat(): ?string
    {
        return $this->nomplat;
    }

    public function setNomplat(string $nomplat): self
    {
        $this->nomplat = $nomplat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrixPlat(): ?int
    {
        return $this->prixPlat;
    }

    public function setPrixPlat(int $prixPlat): self
    {
        $this->prixPlat = $prixPlat;

        return $this;
    }

    public function getQPlat(): ?int
    {
        return $this->qPlat;
    }

    public function setQPlat(int $qPlat): self
    {
        $this->qPlat = $qPlat;

        return $this;
    }

    public function getStock(): ?bool
    {
        return $this->stock;
    }

    public function setStock(bool $stock): self
    {
        $this->stock = $stock;

        return $this;
    }


}

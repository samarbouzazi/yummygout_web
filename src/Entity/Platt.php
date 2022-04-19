<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Platt
 *
 * @ORM\Table(name="platt", indexes={@ORM\Index(name="idcategoriee", columns={"idcatt"})})
 * @ORM\Entity
 *   @UniqueEntity(
 *     fields={"nomplat"},
 *     errorPath="nomplat",
 *     message="ce plat est déjà existe."
 * )
 */
class Platt
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
     * @Assert\NotBlank(message="description est obligatoire")
     * @Groups("post:read")
     *  @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups("post:read")
     */
    private $descplat;

    /**
     * @var string
     *
     * @ORM\Column(name="Nomplat", type="string", length=255, nullable=false)
     *  @Assert\NotBlank(message="nom est obligatoire")
     * @Groups("post:read")
     *  @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 10,
     *      minMessage = "Your nom  must be composed by 3 numbers",
     *      maxMessage = "Your nom must be composed by 10 numbers"
     * )
     * @Groups("post:read")
     * @Groups("post:read")
     */
    private $nomplat;

    /**
     * @var string
     * @Assert\NotBlank(message="image est obligatoire")
     * @Groups("post:read")
     * @ORM\Column(name="image", type="string", length=255, nullable=false)

     * @Groups("post:read")
     */
    private $image;

    /**
     * @var int
     *@Assert\NotBlank(message="le prix est obligatoire")
     * @Groups("post:read")
     * @ORM\Column(name="prix_plat", type="integer", nullable=false)
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups("post:read")
     */
    private $prixPlat;

    /**
     * @var int
     * @Assert\NotBlank(message="quantite du plat est obligatoire")
     * @Groups("post:read")
     * @ORM\Column(name="q_plat", type="integer", nullable=false)
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups("post:read")
     */
    private $qPlat;

    /**
     * @var int
     *@Assert\NotBlank(message="le stock est obligatoire")
     * @Groups("post:read")
     * @ORM\Column(name="stock", type="integer", nullable=false)
     *  @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups("post:read")
     */
    private $stock;

    /**
     * @var \Categorie
     * @Assert\NotBlank(message="id categorie est obligatoire")
     * @Groups("post:read")
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcatt", referencedColumnName="idcatt",onDelete="CASCADE")
     * })
     */
    private $idcatt;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getIdcatt(): ?Categorie
    {
        return $this->idcatt;
    }

    public function setIdcatt(?Categorie $idcatt): self
    {
        $this->idcatt = $idcatt;

        return $this;
    }


}

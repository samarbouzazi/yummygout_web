<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Fournisseurs
 *
 * @ORM\Table(name="fournisseurs")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"addf"},
 *     errorPath="addf",
 *     message="ce fournisseur déjà existe."
 * )
 */
class Fournisseurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="idf", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idf;

    /**
     * @var string
     *
     * @ORM\Column(name="nomf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="nom est obligatoire")
     */
    private $nomf;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="prenom est obligatoire")
     */
    private $prenomf;

    /**
     * @var string
     *
     * @ORM\Column(name="catf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="categorie est obligatoire")
     */
    private $catf;

    /**
     * @var int
     *
     * @ORM\Column(name="telf", type="integer", nullable=false)
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Your phone number must be composed by 8 numbers",
     *      maxMessage = "Your phone number must be composed by 8 numbers"
     * )
     * @Groups("post:read")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\NotBlank(message="contact is required")
     */
    private $telf;

    /**
     * @var string
     *
     * @ORM\Column(name="addf", type="string", length=255, nullable=false)
     * @ORM\Column(name="addf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not valid")
     */
    private $addf;

    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    public function getIdf(): ?int
    {
        return $this->idf;
    }

    public function getNomf(): ?string
    {
        return $this->nomf;
    }

    public function setNomf(string $nomf): self
    {
        $this->nomf = $nomf;

        return $this;
    }

    public function getPrenomf(): ?string
    {
        return $this->prenomf;
    }

    public function setPrenomf(string $prenomf): self
    {
        $this->prenomf = $prenomf;

        return $this;
    }

    public function getCatf(): ?string
    {
        return $this->catf;
    }

    public function setCatf(string $catf): self
    {
        $this->catf = $catf;

        return $this;
    }

    public function getTelf(): ?int
    {
        return $this->telf;
    }

    public function setTelf(int $telf): self
    {
        $this->telf = $telf;

        return $this;
    }

    public function getAddf(): ?string
    {
        return $this->addf;
    }

    public function setAddf(string $addf): self
    {
        $this->addf = $addf;

        return $this;
    }


}

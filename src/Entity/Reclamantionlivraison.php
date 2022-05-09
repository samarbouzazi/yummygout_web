<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Reclamantionlivraison
 *
 * @ORM\Table(name="reclamantionlivraison", indexes={@ORM\Index(name="idlivvv", columns={"id_livraison"})})
 * @ORM\Entity
 */
class Reclamantionlivraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="idreclivv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups ("post:read")
     */
    private $idreclivv;

    /**
     * @var string
     *
     * @ORM\Column(name="reclamation", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $reclamation;

    /**
     * @var \Date
     *
     * @ORM\Column(name="createdat", type="date", nullable=false)
     * @Groups ("post:read")
     */
    private $createdat;

    /**
     * @var \Date
     *
     * @ORM\Column(name="updatedat", type="date", nullable=false)
     * @Groups ("post:read")
     */
    private $updatedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujetrec", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $sujetrec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="clientname", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $clientname;

    /**
     * @var \Livraison
     *
     * @ORM\ManyToOne(targetEntity="Livraison")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_livraison", referencedColumnName="id_livraison")
     * })
     *
     */
    private $idLivraison;

    public function getIdreclivv(): ?int
    {
        return $this->idreclivv;
    }

    public function getReclamation(): ?string
    {
        return $this->reclamation;
    }

    public function setReclamation(?string $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getSujetrec(): ?string
    {
        return $this->sujetrec;
    }

    public function setSujetrec(?string $sujetrec): self
    {
        $this->sujetrec = $sujetrec;

        return $this;
    }

    public function getClientname(): ?string
    {
        return $this->clientname;
    }

    public function setClientname(?string $clientname): self
    {
        $this->clientname = $clientname;

        return $this;
    }

    public function getIdLivraison(): ?Livraison
    {
        return $this->idLivraison;
    }

    public function setIdLivraison(?Livraison $idLivraison): self
    {
        $this->idLivraison = $idLivraison;

        return $this;
    }


}

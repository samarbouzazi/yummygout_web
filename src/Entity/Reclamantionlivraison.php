<?php

namespace App\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $idreclivv;

    /**
     * @var string
     *
     * @ORM\Column(name="reclamation", type="string", length=255, nullable=false)
     */
    private $reclamation;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable (on="create")
     * @ORM\Column(name="createdat", type="datetime", nullable=false)
     */
    private $createdat;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable (on="update")
     * @ORM\Column(name="updatedat", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @var string
     *
     * @ORM\Column(name="sujetrec", type="string", length=255, nullable=false)
     */
    private $sujetrec;

    /**
     * @var string
     *
     * @ORM\Column(name="clientname", type="string", length=255, nullable=false)
     */
    private $clientname;

    /**
     * @var \Livraison
     *
     * @ORM\ManyToOne(targetEntity="Livraison")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_livraison", referencedColumnName="id_livraison")
     * })
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

    public function setReclamation(string $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getSujetrec(): ?string
    {
        return $this->sujetrec;
    }

    public function setSujetrec(string $sujetrec): self
    {
        $this->sujetrec = $sujetrec;

        return $this;
    }

    public function getClientname(): ?string
    {
        return $this->clientname;
    }

    public function setClientname(string $clientname): self
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

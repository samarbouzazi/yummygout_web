<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\Length(
     *      min = 10,
     *      max = 2555,
     *      minMessage = "la reclamation doit contenir au moins 10 ",
     *      maxMessage = "la reclamation doint contenir au plus 2555")
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

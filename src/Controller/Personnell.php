<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Personnell
 *
 * @ORM\Table(name="personnell")
 * @ORM\Entity(repositoryClass="App\Repository\PersonnellRepository")
 * @UniqueEntity(fields={"email", "cinp"}, message="already exists")
 */
class Personnell
{
    /**
     * @var int
     *
     * @ORM\Column(name="Idp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\NotBlank(message= "firstname field is empty !")
     */
    private $nomp;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your lastt name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\NotBlank(message= "lastname field is empty !")
     */
    private $prenomp;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Length(min = 8, maxMessage="your phone number must be 8 digits")
     * @Assert\NotBlank(message= "cin field is empty !")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $cinp;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Length(min = 8, maxMessage="your phone number must be 8 digits")
     * @Assert\NotBlank(message= "phone field is empty !")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $telp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message= "email field is empty !")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="Salaire", type="integer", nullable=false)
     * @Assert\NotBlank(message= "email field is empty !")
     */
    private $salaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Specialite", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message= "email field is empty !")
     */
    private $specialite;

    /**
     * @ORM\Column(type="integer", length=255, nullable=false)
     * @Assert\Range(
     *      min = 6,
     *      max = 10,
     *      notInRangeMessage = "Hours must be between {{ min }}h and {{ max }}h ",
     * )
     * @Assert\NotBlank(message= "hours field is empty !")
     */
    private $nbheure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_embauche", type="date", nullable=false)
     * @Assert\NotBlank(message= "date field is empty !")
     */
    private $dateEmbauche;

    /**
     * @var boolean|null
     *
     * @ORM\Column(name="Disponibilite", type="boolean", nullable=true)
     */
    private $disponibilite;

    /**
     * @var int
     *
     * @ORM\Column(name="taux_horaire", type="integer", nullable=false, options={"default"="50"})
     */
    private $tauxHoraire = 50;

    /**
     * @var float|null
     *
     * @ORM\Column(name="prime", type="float", precision=10, scale=0, nullable=true)
     * @Assert\NotBlank(message= "hours field is empty !")
     */
    private $prime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Zonegeo", type="string", length=255, nullable=true)
     */
    private $zonegeo;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="personnell", cascade={"persist", "remove"})
     */
    private $user;



    public function getIdp(): ?int
    {
        return $this->idp;
    }

    /**
     * @param int $idp
     */
    public function setIdp(int $idp): void
    {
        $this->idp = $idp;
    }


    public function getNomp(): ?string
    {
        return $this->nomp;
    }

    public function setNomp(string $nomp): self
    {
        $this->nomp = $nomp;

        return $this;
    }

    public function getPrenomp(): ?string
    {
        return $this->prenomp;
    }

    public function setPrenomp(string $prenomp): self
    {
        $this->prenomp = $prenomp;

        return $this;
    }

    public function getCinp(): ?int
    {
        return $this->cinp;
    }

    public function setCinp(int $cinp): self
    {
        $this->cinp = $cinp;

        return $this;
    }

    public function getTelp(): ?int
    {
        return $this->telp;
    }

    public function setTelp(int $telp): self
    {
        $this->telp = $telp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getNbheure(): ?int
    {
        return $this->nbheure;
    }

    public function setNbheure(int $nbheure): self
    {
        $this->nbheure = $nbheure;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTimeInterface $dateEmbauche): self
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }



    public function getTauxHoraire(): ?int
    {
        return $this->tauxHoraire;
    }

    public function setTauxHoraire(int $tauxHoraire): self
    {
        $this->tauxHoraire = $tauxHoraire;

        return $this;
    }

    public function getPrime(): ?float
    {
        return $this->prime;
    }

    public function setPrime(?float $prime): self
    {
        $this->prime = $prime;

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

    public function getZonegeo(): ?string
    {
        return $this->zonegeo;
    }

    public function setZonegeo(?string $zonegeo): self
    {
        $this->zonegeo = $zonegeo;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    /**
     * @param bool|null $disponibilite
     */
    public function setDisponibilite(?bool $disponibilite): void
    {
        $this->disponibilite = $disponibilite;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }





}

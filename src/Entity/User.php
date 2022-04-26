<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType ;




/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180,nullable=false)
     * @Assert\NotBlank(message= "email field is empty !")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 6,
     *
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *
     *     )
     *
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;



    public function __construct()
    {
        $this->Roles = new ArrayCollection();
        $this->reportUsers = new ArrayCollection();
        $this->passwordTokens = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message= "address field is empty !")
     *
     *
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Length(min = 8, maxMessage="your phone number must be 8 digits")
     * @Assert\NotBlank(message= "phone field is empty !")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
    */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Assert\NotBlank(message= "firstname field is empty !")
     *  @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     * @Assert\NotBlank(message="lastname field is empty !")
     *  @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;


    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false )
     */
    private $active = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message= "Captcha field is empty !")
     */
    private $captcha;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private $facebookID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private $facebookAccessToken;

    /**
     * @ORM\OneToMany(targetEntity=ReportUser::class, mappedBy="user")
     */
    private $reportUsers;

    /**
     * @ORM\OneToMany(targetEntity=ResetPasswordRequest::class, mappedBy="user", orphanRemoval=true)
     */
    private $resetpasswordrequest;

    /**
     * @return mixed
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param mixed $facebookID
     */
    public function setFacebookID($facebookID): void
    {
        $this->facebookID = $facebookID;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * @param mixed $facebookAccessToken
     */
    public function setFacebookAccessToken($facebookAccessToken): void
    {
        $this->facebookAccessToken = $facebookAccessToken;
    }


    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }


    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param mixed $captcha
     */
    public function setCaptcha($captcha): void
    {
        $this->captcha = $captcha;
    }



    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
    public function addRole(Role $role): self
    {
        if (!$this->Roles->contains($role)) {
            $this->Roles[] = $role;
            $role->setUser($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->Roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUser() === $this) {
                $role->setUser(null);
            }
        }

        return $this;
    }

    public function getPersonnell(): ?Personnell
    {
        return $this->personnell;
    }

    public function setPersonnell(?Personnell $personnell): self
    {
        // unset the owning side of the relation if necessary
        if ($personnell === null && $this->personnell !== null) {
            $this->personnell->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($personnell !== null && $personnell->getUser() !== $this) {
            $personnell->setUser($this);
        }

        $this->personnell = $personnell;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $isVerified
     */
    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }



    /**
     * @return Collection|ReportUser[]
     */
    public function getReportUsers(): Collection
    {
        return $this->reportUsers;
    }

    public function addReportUser(ReportUser $reportUser): self
    {
        if (!$this->reportUsers->contains($reportUser)) {
            $this->reportUsers[] = $reportUser;
            $reportUser->setUser($this);
        }

        return $this;
    }

    public function removeReportUser(ReportUser $reportUser): self
    {
        if ($this->reportUsers->removeElement($reportUser)) {
            // set the owning side to null (unless already changed)
            if ($reportUser->getUser() === $this) {
                $reportUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResetPasswordRequest[]
     */
    public function getResetpasswordrequest(): Collection
    {
        return $this->resetpasswordrequest;
    }

    public function addResetpasswordrequest(ResetPasswordRequest $resetPasswordRequest): self
    {
        if (!$this->resetpasswordrequest->contains($resetPasswordRequest)) {
            $this->resetpasswordrequest[] = $resetPasswordRequest;
            $resetPasswordRequest->setUser($this);
        }

        return $this;
    }

    public function removeResetpasswordrequest(ResetPasswordRequest $resetPasswordRequest): self
    {
        if ($this->resetpasswordrequest->removeElement($resetPasswordRequest)) {
            // set the owning side to null (unless already changed)
            if ($resetPasswordRequest->getUser() === $this) {
                $resetPasswordRequest->setUser(null);
            }
        }

        return $this;
    }

}

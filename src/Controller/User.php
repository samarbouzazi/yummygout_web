<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;



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
     * @ORM\Column(type="string", length=180)
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
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *     )
     *
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="user")
     */
    private $Roles;

    public function __construct()
    {
        $this->Roles = new ArrayCollection();
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
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity=Personnell::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $personnell;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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
    public function getPassword(): string
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
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

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
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



}

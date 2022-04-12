<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Blog
 *
 * @ORM\Table(name="blog")
 * @ORM\Entity
 *   @UniqueEntity(
 *     fields={"titreblog"},
 *     errorPath="titreblog",
 *     message="blog est déjà existe."
 * )
 */
class Blog
{
    /**
     * @var int
     *
     * @ORM\Column(name="Idblog", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idblog;

    /**
     * @var string
     *
     * @ORM\Column(name="titreblog", type="string", length=200, nullable=false)
     * * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "Your first name must be at least 2 characters long",
     *      maxMessage = "Your first name cannot be longer than 10 characters"
     * )
     * @Groups("post:read")
     */

    private $titreblog;

    /**
     * @var string
     *
     * @ORM\Column(name="descblog", type="string", length=200, nullable=false)
     * @Assert\NotBlank(message="blog is required")
     */
    private $descblog;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    public function getIdblog(): ?int
    {
        return $this->idblog;
    }

    public function getTitreblog(): ?string
    {
        return $this->titreblog;
    }

    public function setTitreblog(string $titreblog): self
    {
        $this->titreblog = $titreblog;

        return $this;
    }

    public function getDescblog(): ?string
    {
        return $this->descblog;
    }

    public function setDescblog(string $descblog): self
    {
        $this->descblog = $descblog;

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


}

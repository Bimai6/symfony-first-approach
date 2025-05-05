<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    private ?string $surname = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $age = null;

    #[ORM\Column(length: 9)]
    #[Assert\NotBlank]
    #[Assert\Regex( pattern: '/^[0-9]{8}[A-Z]$/')]
    private ?string $dni = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'user')]
    private Collection $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): static
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(post $post): static
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function __construct() {
        $this->created_at = new \DateTimeImmutable("now");
    }
}

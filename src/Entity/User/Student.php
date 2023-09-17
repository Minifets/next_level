<?php

namespace App\Entity\User;

use App\Entity\Progress\Progress;
use App\Entity\Progress\Reward;
use App\Repository\User\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Student implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'stugent', cascade: ['persist', 'remove'])]
    private ?Progress $progress = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Reward::class, orphanRemoval: true)]
    private Collection $rewards;

    public function __construct()
    {
        $this->rewards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProgress(): ?Progress
    {
        return $this->progress;
    }

    public function setProgress(Progress $progress): static
    {
        // set the owning side of the relation if necessary
        if ($progress->getStugent() !== $this) {
            $progress->setStugent($this);
        }

        $this->progress = $progress;

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): static
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->setStudent($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): static
    {
        if ($this->rewards->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getStudent() === $this) {
                $reward->setStudent(null);
            }
        }

        return $this;
    }
}

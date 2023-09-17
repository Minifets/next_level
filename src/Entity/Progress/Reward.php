<?php

namespace App\Entity\Progress;

use App\Entity\User\Student;
use App\Repository\Progress\RewardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RewardRepository::class)]
class Reward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rewards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Achievement $achievement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getAchievement(): ?Achievement
    {
        return $this->achievement;
    }

    public function setAchievement(?Achievement $achievement): static
    {
        $this->achievement = $achievement;

        return $this;
    }
}

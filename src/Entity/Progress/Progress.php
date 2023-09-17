<?php

namespace App\Entity\Progress;

use App\Entity\Milestone\Stage;
use App\Entity\User\Student;
use App\Repository\Progress\ProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressRepository::class)]
class Progress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'progress', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $stugent = null;

    #[ORM\ManyToOne]
    private ?Stage $stage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStugent(): ?Student
    {
        return $this->stugent;
    }

    public function setStugent(Student $stugent): static
    {
        $this->stugent = $stugent;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }
}

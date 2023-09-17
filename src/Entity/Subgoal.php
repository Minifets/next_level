<?php

namespace App\Entity;

use App\Repository\SubgoalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubgoalRepository::class)]
class Subgoal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subgoals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Milestone $milestone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    public function setMilestone(?Milestone $milestone): static
    {
        $this->milestone = $milestone;

        return $this;
    }
}

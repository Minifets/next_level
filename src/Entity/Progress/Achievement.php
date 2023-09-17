<?php

namespace App\Entity\Progress;

use App\Entity\Milestone\Milestone;
use App\Repository\Progress\AchievementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fallbackImage = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToOne(inversedBy: 'achievement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Milestone $milestone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFallbackImage(): ?string
    {
        return $this->fallbackImage;
    }

    public function setFallbackImage(string $fallbackImage): static
    {
        $this->fallbackImage = $fallbackImage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    public function setMilestone(Milestone $milestone): static
    {
        $this->milestone = $milestone;

        return $this;
    }
}

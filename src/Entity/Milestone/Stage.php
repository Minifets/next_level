<?php

namespace App\Entity\Milestone;

use App\Entity\Lesson\Lesson;
use App\Repository\Milestone\StageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Milestone $milestone = null;

    #[ORM\Column(unique: false)]
    private ?int $stageOrder = null;

    #[ORM\OneToOne(mappedBy: 'stage', cascade: ['persist', 'remove'])]
    private ?Lesson $lesson = null;

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getStageOrder(): ?int
    {
        return $this->stageOrder;
    }

    public function setStageOrder(int $stageOrder): static
    {
        $this->stageOrder = $stageOrder;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson): static
    {
        // set the owning side of the relation if necessary
        if ($lesson->getStage() !== $this) {
            $lesson->setStage($this);
        }

        $this->lesson = $lesson;

        return $this;
    }
}

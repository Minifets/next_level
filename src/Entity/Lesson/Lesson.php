<?php

namespace App\Entity\Lesson;

use App\Entity\Milestone\Stage;
use App\Repository\Lesson\LessonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToOne(mappedBy: 'lesson', cascade: ['persist', 'remove'])]
    private ?Exam $exam = null;

    #[ORM\OneToOne(inversedBy: 'lesson', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    public function __toString(): string
    {
        return $this->getStage()?->getTitle() ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getExam(): ?Exam
    {
        return $this->exam;
    }

    public function setExam(?Exam $exam): static
    {
        // unset the owning side of the relation if necessary
        if ($exam === null && $this->exam !== null) {
            $this->exam->setLesson(null);
        }

        // set the owning side of the relation if necessary
        if ($exam !== null && $exam->getLesson() !== $this) {
            $exam->setLesson($this);
        }

        $this->exam = $exam;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }
}

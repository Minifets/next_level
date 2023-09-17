<?php

namespace App\Entity\Milestone;

use App\Repository\Milestone\MilestoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MilestoneRepository::class)]
class Milestone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'nextMilestones')]
    private ?self $previous = null;

    #[ORM\OneToMany(mappedBy: 'previous', targetEntity: self::class)]
    private Collection $nextMilestones;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: Stage::class)]
    private Collection $stages;

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    public function __construct()
    {
        $this->nextMilestones = new ArrayCollection();
        $this->stages = new ArrayCollection();
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

    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    public function setPrevious(?self $previous): static
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getNextMilestones(): Collection
    {
        return $this->nextMilestones;
    }

    public function addNextMilestone(self $nextMilestone): static
    {
        if (!$this->nextMilestones->contains($nextMilestone)) {
            $this->nextMilestones->add($nextMilestone);
            $nextMilestone->setPrevious($this);
        }

        return $this;
    }

    public function removeNextMilestone(self $nextMilestone): static
    {
        if ($this->nextMilestones->removeElement($nextMilestone)) {
            // set the owning side to null (unless already changed)
            if ($nextMilestone->getPrevious() === $this) {
                $nextMilestone->setPrevious(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): static
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setMilestone($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getMilestone() === $this) {
                $stage->setMilestone(null);
            }
        }

        return $this;
    }
}

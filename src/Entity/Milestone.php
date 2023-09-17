<?php

namespace App\Entity;

use App\Repository\MilestoneRepository;
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

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'nextMilestones')]
    private ?self $previous = null;

    #[ORM\OneToMany(mappedBy: 'previous', targetEntity: self::class)]
    private Collection $nextMilestones;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: Subgoal::class)]
    private Collection $subgoals;

    public function __construct()
    {
        $this->nextMilestones = new ArrayCollection();
        $this->subgoals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Subgoal>
     */
    public function getSubgoals(): Collection
    {
        return $this->subgoals;
    }

    public function addSubgoal(Subgoal $subgoal): static
    {
        if (!$this->subgoals->contains($subgoal)) {
            $this->subgoals->add($subgoal);
            $subgoal->setMilestone($this);
        }

        return $this;
    }

    public function removeSubgoal(Subgoal $subgoal): static
    {
        if ($this->subgoals->removeElement($subgoal)) {
            // set the owning side to null (unless already changed)
            if ($subgoal->getMilestone() === $this) {
                $subgoal->setMilestone(null);
            }
        }

        return $this;
    }
}

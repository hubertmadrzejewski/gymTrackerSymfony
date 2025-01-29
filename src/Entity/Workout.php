<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'workouts')]
    private ?User $whoDid = null;

    /**
     * @var Collection<int, WorkoutSet>
     */
    #[ORM\OneToMany(targetEntity: WorkoutSet::class, mappedBy: 'workout')]
    private Collection $workoutSets;

    public function __construct()
    {
        $this->workoutSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getWhoDid(): ?User
    {
        return $this->whoDid;
    }

    public function setWhoDid(?User $whoDid): static
    {
        $this->whoDid = $whoDid;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutSet>
     */
    public function getWorkoutSets(): Collection
    {
        return $this->workoutSets;
    }

    public function addWorkoutSet(WorkoutSet $workoutSet): static
    {
        if (!$this->workoutSets->contains($workoutSet)) {
            $this->workoutSets->add($workoutSet);
            $workoutSet->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutSet(WorkoutSet $workoutSet): static
    {
        if ($this->workoutSets->removeElement($workoutSet)) {
            // set the owning side to null (unless already changed)
            if ($workoutSet->getWorkout() === $this) {
                $workoutSet->setWorkout(null);
            }
        }

        return $this;
    }
}

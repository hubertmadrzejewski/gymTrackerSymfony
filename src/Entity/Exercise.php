<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nazwa nie może być pusta')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Nazwa nie może być dłuższa niż {{ limit }} znaków'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Musisz podać grupę mięśniową')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Grupa mięśniowa nie może być dłuższa niż {{ limit }} znaków'
    )]
    private ?string $muscleGroup = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Pole "equipment" nie może być dłuższe niż {{ limit }} znaków'
    )]
    // NotBlank nie ma sensu dla pola, które jest opcjonalne, więc go nie dajemy
    private ?string $equipment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getMuscleGroup(): ?string
    {
        return $this->muscleGroup;
    }

    public function setMuscleGroup(string $muscleGroup): static
    {
        $this->muscleGroup = $muscleGroup;
        return $this;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(?string $equipment): static
    {
        $this->equipment = $equipment;
        return $this;
    }
}

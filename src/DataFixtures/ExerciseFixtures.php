<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exercises = [
            ['name' => 'Bench Press', 'muscleGroup' => 'Chest', 'equipment' => 'Barbell'],
            ['name' => 'Squat', 'muscleGroup' => 'Legs', 'equipment' => 'Barbell'],
            ['name' => 'Deadlift', 'muscleGroup' => 'Back', 'equipment' => 'Barbell'],
            ['name' => 'Pull-up', 'muscleGroup' => 'Back', 'equipment' => null],
            ['name' => 'Bicep Curl', 'muscleGroup' => 'Biceps', 'equipment' => 'Dumbbell'],
        ];

        foreach ($exercises as $data) {
            $exercise = new Exercise();
            $exercise->setName($data['name']);
            $exercise->setMuscleGroup($data['muscleGroup']);
            $exercise->setEquipment($data['equipment'] ?? null);

            $manager->persist($exercise);
        }

        $manager->flush();
    }
}

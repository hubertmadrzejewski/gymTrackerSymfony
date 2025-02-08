<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Workout;
use Doctrine\ORM\EntityManagerInterface;

class WorkoutService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Creates a new Workout entity for a given User and date,
     * then saves it to the database.
     */
    public function createWorkout(User $user, \DateTimeInterface $date): Workout
    {
        $workout = new Workout();
        $workout->setWhoDid($user);
        $workout->setDate($date);

        $this->em->persist($workout);
        $this->em->flush();

        return $workout;
    }
}

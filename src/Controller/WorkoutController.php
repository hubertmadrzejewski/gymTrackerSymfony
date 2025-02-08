<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\WorkoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    public function __construct(private WorkoutService $workoutService)
    {
    }

    #[Route('/api/workout/create', name: 'create_workout')]
    public function createWorkout(): JsonResponse
    {

        /** @var User $user */
        $user = $this->getUser();
        $date = new \DateTimeImmutable();

        $workout = $this->workoutService->createWorkout($user, $date);

        return $this->json([
            'status' => 'success',
            'workoutId' => $workout->getId(),
        ]);
    }
}

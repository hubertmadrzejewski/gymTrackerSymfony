<?php

namespace App\Controller;

use App\Entity\Exercise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/exercise')]
class ExerciseController extends AbstractController
{
    #[Route('/create', name: 'create_exercise', methods: ['POST'])]
    public function createExercise(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $exercise = new Exercise();

        $exercise->setName($data['name'] ?? '');
        $exercise->setMuscleGroup($data['muscleGroup'] ?? '');
        $exercise->setEquipment($data['equipment'] ?? null);

        $errors = $validator->validate($exercise);
        if (count($errors) > 0) {
            $errorsArr = [];
            foreach ($errors as $error) {
                $errorsArr[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage()
                ];
            }

            return new JsonResponse([
                'status' => 'error',
                'errors' => $errorsArr,
            ], 400);
        }

        $em->persist($exercise);
        $em->flush();

        return new JsonResponse([
            'status' => 'success',
            'id' => $exercise->getId(),
        ], 201);
    }
}

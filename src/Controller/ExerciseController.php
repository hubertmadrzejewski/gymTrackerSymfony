<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

#[Route('/api/exercise')]
class ExerciseController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function createExercise(Request $request, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        try {
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
                return new JsonResponse(['status' => 'error', 'errors' => $errorsArr], Response::HTTP_BAD_REQUEST);
            }

            $em->persist($exercise);
            $em->flush();

            return new JsonResponse(['status' => 'success', 'id' => $exercise->getId()], Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/all', methods: ['GET'])]
    public function getAllExercises(ExerciseRepository $repo): JsonResponse
    {
        try {
            $exercises = $repo->findAll();
            $data = [];
            foreach ($exercises as $ex) {
                $data[] = [
                    'id' => $ex->getId(),
                    'name' => $ex->getName(),
                    'muscleGroup' => $ex->getMuscleGroup(),
                    'equipment' => $ex->getEquipment(),
                ];
            }
            return new JsonResponse(['status' => 'success', 'count' => count($data), 'data' => $data], Response::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id<\d+>}', methods: ['GET'])]
    public function getExercise(int $id, ExerciseRepository $repo): JsonResponse
    {
        try {
            $exercise = $repo->find($id);
            if (!$exercise) {
                return new JsonResponse(['status' => 'error', 'message' => 'Not found'], Response::HTTP_NOT_FOUND);
            }
            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'id' => $exercise->getId(),
                    'name' => $exercise->getName(),
                    'muscleGroup' => $exercise->getMuscleGroup(),
                    'equipment' => $exercise->getEquipment(),
                ]
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id<\d+>}', methods: ['PUT'])]
    public function editExercise(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        try {
            $exercise = $em->getRepository(Exercise::class)->find($id);
            if (!$exercise) {
                return new JsonResponse(['status' => 'error', 'message' => 'Not found'], Response::HTTP_NOT_FOUND);
            }

            $data = json_decode($request->getContent(), true);
            if (isset($data['name'])) {
                $exercise->setName($data['name']);
            }
            if (isset($data['muscleGroup'])) {
                $exercise->setMuscleGroup($data['muscleGroup']);
            }
            if (array_key_exists('equipment', $data)) {
                $exercise->setEquipment($data['equipment']);
            }

            $errors = $validator->validate($exercise);
            if (count($errors) > 0) {
                $errorsArr = [];
                foreach ($errors as $error) {
                    $errorsArr[] = [
                        'field' => $error->getPropertyPath(),
                        'message' => $error->getMessage(),
                    ];
                }
                return new JsonResponse(['status' => 'error', 'errors' => $errorsArr], Response::HTTP_BAD_REQUEST);
            }

            $em->flush();
            return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function deleteExercise(int $id, EntityManagerInterface $em): JsonResponse
    {
        try {
            $exercise = $em->getRepository(Exercise::class)->find($id);
            if (!$exercise) {
                return new JsonResponse(['status' => 'error', 'message' => 'Not found'], Response::HTTP_NOT_FOUND);
            }
            $em->remove($exercise);
            $em->flush();
            return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

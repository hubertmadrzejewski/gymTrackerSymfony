<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/api/users/show', name:  'app_user', methods: ['GET'])]
    public function showUser(): JsonResponse
    {
        $currentUser = $this->getUser();

        return  new JsonResponse([
            'data' => [
                'id' => $currentUser->getId(),
                'email' => $currentUser->getEmail(),
            ],
            'status' => Response::HTTP_OK,
            'messages' => NULL,
            'errors' => NULL,
            'additionalData' => NULL,
        ]);
    }
}

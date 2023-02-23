<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiIsLoggedInController extends AbstractController
{
    #[Route('/api/protected/isLoggedIn', name: 'api_is_logged_in')]
    public function isLoggedIn(): Response
    {
        return $this->json([
            'isLoggedIn' => true
        ]);
    }

}

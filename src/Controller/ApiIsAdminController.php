<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiIsAdminController extends AbstractController
{
    #[Route('/api/is-admin', name: 'app_api_is_admin')]
    public function index(): Response
    {
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        return $this->json([
            'isAdmin' => $isAdmin
        ]);
    }
}

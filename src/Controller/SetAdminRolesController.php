<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetAdminRolesController extends AbstractController
{
    #[Route('/set/admin/roles', name: 'app_set_admin_roles')]
    public function index(ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $admins = [
            "test@test.com",
            "sewelseb@hotmail.com",
        ];

        foreach ($admins as $adminEmail)
        {
            $admin = $doctrine->getRepository(User::class)->findOneBy(['email' => $adminEmail]);
            $admin->addRole('ROLE_ADMIN');
            $entityManager->persist($admin);
            $entityManager->flush();
        }


        return $this->json([
            'success' => true
        ]);
    }
}

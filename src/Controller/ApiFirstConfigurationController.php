<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiFirstConfigurationController extends AbstractController
{
    #[Route('/api/protected/first-configuration', name: 'app_api_first_configuration', methods: ['POST'])]
    public function index(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();


        $content = $request->getContent();
        $jsonData = json_decode($content, true);

        $user->setCourseSubject($jsonData["courseSubject"]);
        $user->setTeacher($jsonData["teacher"]);
        $user->setIsRecievingComercialEmails($jsonData["isRecievingCommercialEmails"]);
        $user->setFirstConnectionDone(true);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'Updated' => "Success"
        ]);
    }

    #[Route('/api/protected/first-configuration', name: 'app_api_is_first_configuration_done', methods: ['GET'])]
    public function isFirstConfigurationDone(): Response{
        return $this->json([
            'isFirstConfigurationDone' => $this->getUser()->getFirstConnectionDone()
        ]);
    }

    private function getCustomUser(Request $request, ManagerRegistry $doctrine): ?User {
        return $doctrine->getRepository(User::class)->findOneBy(['apiToken' => $request->headers->get('X-AUTH-TOKEN')]);
    }
}

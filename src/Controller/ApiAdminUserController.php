<?php

namespace App\Controller;

use App\Controller\Dto\DtoUser;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiAdminUserController extends AbstractController
{
    #[Route('/api/admin/users/get-all', name: 'app_admin_get_all_user')]
    public function getAllAction(ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();

        $dtoUsers = [];

        $i = 0;
        foreach ($users as $user)
        {
            $dtoUser = new DtoUser($user);

            //$dtoUsers[] = $this->serialize($dtoUser, $serializer);
            $dtoUsers[$i] = $dtoUser;
            $i++;
        }

        return $this->json([
            'users'  => $dtoUsers
        ]);
    }


}

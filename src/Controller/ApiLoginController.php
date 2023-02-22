<?php

namespace App\Controller;

use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;

use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $credentials['email'] = $request->request->get('email');
        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);



         if (null === $user) {
             return $this->json([
                 'message' => 'missing credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

        $isPasswordvalid = $userPasswordHasher->isPasswordValid(
            $user,
            $request->request->get('password')
        );

         if(!$isPasswordvalid) {
             return $this->json([
                 'message' => 'invalid credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

         $entityManager = $doctrine->getManager();
         $token = sha1(rand());

         $user->setApiToken($token);
         $entityManager->persist($user);

          return $this->json([
              'user'  => $user->getUserIdentifier(),
              'token' => $token,
          ]);
    }
}

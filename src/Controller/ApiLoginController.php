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

        $credentials = $this->getCredentials($request);
        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

         if (null === $user) {
             return $this->json([
                 'message' => 'missing credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

        $isPasswordValid = $this->isPasswordValid($userPasswordHasher, $user, $credentials["password"]);

        if(!$isPasswordValid) {
             return $this->json([
                 'message' => 'invalid credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

         $entityManager = $doctrine->getManager();
         $token = sha1(rand());

         $user->setApiToken($token);
         $entityManager->persist($user);
         $entityManager->flush();

          return $this->json([
              'user'  => $user->getUserIdentifier(),
              'token' => $token,
          ]);
    }


        /**
     * @param Request $request
     * @return mixed
     */
    public function getCredentials(Request $request): mixed
    {
        $content = $request->getContent();
        $credentials = json_decode($content, true);

        if ($credentials['password'] === null && $credentials['email'] === null) {
            $credentials = $this->getPlainTextCredentials($request, $credentials);
        }
        return $credentials;
    }

    /**
     * @param Request $request
     * @param mixed $credentials
     * @return mixed
     */
    public function getPlainTextCredentials(Request $request, mixed $credentials): mixed
    {
        $credentials["email"] = $request->request->get('email');
        $credentials["password"] = $request->request->get('password');
        return $credentials;
    }

    /**
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param object $user
     * @param $password
     * @return bool
     */
    public function isPasswordValid(UserPasswordHasherInterface $userPasswordHasher, object $user, $password): bool
    {
        $isPasswordvalid = $userPasswordHasher->isPasswordValid(
            $user,
            $password
        );
        return $isPasswordvalid;
    }
}

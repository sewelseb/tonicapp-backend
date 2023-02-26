<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\ApiKeyAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ApiRegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, ApiKeyAuthenticator $authenticator, UserAuthenticatorInterface $userAuthenticator, EntityManagerInterface $entityManager):Response
    {
        try{
            $credentials = $this->getCredentials($request);

            $user = $this->createUser($credentials, $userPasswordHasher, $entityManager);

            return $this->json([
                'email'  => $user->getUserIdentifier()
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => 'user creation error',
                'exception' => $exception
            ], 500);
        }
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
     * @param mixed $credentials
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @return User
     */
    public function createUser(mixed $credentials, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): User
    {
        $user = new User();
        $user->setEmail($credentials["email"]);
        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $credentials["password"]
            )
        );

        //var_dump($user);

        $entityManager->persist($user);
        $entityManager->flush();
        return $user;
    }
}
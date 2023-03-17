<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(nullable: true)]
    private $apiToken;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $firstConnectionDone;

    #[ORM\Column(nullable: true)]
    private $teacher;

    #[ORM\Column(nullable: true)]
    private $courseSubject;

    #[ORM\Column(nullable: true)]
    private $school;

    #[ORM\Column(type: 'boolean')]
    private $isRecievingComercialEmails = false;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstConnectionDone()
    {
        return $this->firstConnectionDone;
    }

    /**
     * @param mixed $firstConnectionDone
     */
    public function setFirstConnectionDone($firstConnectionDone): void
    {
        $this->firstConnectionDone = $firstConnectionDone;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getCourseSubject()
    {
        return $this->courseSubject;
    }

    /**
     * @param mixed $courseSubject
     */
    public function setCourseSubject($courseSubject): void
    {
        $this->courseSubject = $courseSubject;
    }

    /**
     * @return bool
     */
    public function isRecievingComercialEmails(): bool
    {
        return $this->isRecievingComercialEmails;
    }

    /**
     * @param bool $isRecievingComercialEmails
     */
    public function setIsRecievingComercialEmails(bool $isRecievingComercialEmails): void
    {
        $this->isRecievingComercialEmails = $isRecievingComercialEmails;
    }

    /**
     * @return mixed
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school): void
    {
        $this->school = $school;
    }



}

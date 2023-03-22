<?php

namespace App\Controller\Dto;

use App\Entity\User;

class DtoUser
{
    private $id;
    private $email;
    private $teacher;
    private $courseSubject;
    private $school;
    private $isRecevedComercialEmails;

    /**
     * @param mixed|object $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->teacher = $user->getTeacher();
        $this->courseSubject = $user->getCourseSubject();
        $this->school = $user->getSchool();
        $this->isRecevedComercialEmails = $user->isRecievingComercialEmails();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTeacher(): mixed
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher(mixed $teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getCourseSubject(): mixed
    {
        return $this->courseSubject;
    }

    /**
     * @param mixed $courseSubject
     */
    public function setCourseSubject(mixed $courseSubject): void
    {
        $this->courseSubject = $courseSubject;
    }

    /**
     * @return mixed
     */
    public function getSchool(): mixed
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool(mixed $school): void
    {
        $this->school = $school;
    }

    /**
     * @return bool
     */
    public function isRecevedComercialEmails(): bool
    {
        return $this->isRecevedComercialEmails;
    }

    /**
     * @param bool $isRecevedComercialEmails
     */
    public function setIsRecevedComercialEmails(bool $isRecevedComercialEmails): void
    {
        $this->isRecevedComercialEmails = $isRecevedComercialEmails;
    }

    
/*
    public function jsonSerialize(): mixed
    {
        return json_encode( $this );
    }*/
}
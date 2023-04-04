<?php

namespace StudentList\Models\StudentModel;

class Student
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $gender;
    protected $dateOfBirth;
    protected $email;
    protected $groupNumber;
    protected $examScores;
    protected $residence;
    
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const RESIDENCE_RESIDENT = 'resident';
    const RESIDENCE_NONRESIDENT = 'nonresident';

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getGroupNumber(): ?string
    {
        return $this->groupNumber;
    }

    public function getExamScores(): ?string
    {
        return $this->examScores;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function fillFromArray(array $data): void
    {
        $this->firstname = trim(strval($data['firstname'] ?? ''));
        $this->lastname = trim(strval($data['lastname'] ?? ''));
        $this->gender = trim(strval($data['gender'] ?? ''));
        $this->dateOfBirth = trim(strval($data['dateOfBirth'] ?? ''));
        $this->email = trim(strval($data['email'] ?? ''));
        $this->groupNumber = trim(strval($data['groupNumber'] ?? ''));
        $this->examScores = trim(strval($data['examScores'] ?? ''));
        $this->residence = trim(strval($data['residence'] ?? ''));
    }
}

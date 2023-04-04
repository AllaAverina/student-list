<?php

namespace StudentList\Models\StudentModel;

use StudentList\Models\StudentModel\{StudentGateway, Student};

class StudentValidator
{
    protected $gateway;

    public function __construct(StudentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function validate(Student $student)
    {
        $formErrors = [];
        $formErrors['firstnameError'] = $this->validateName($student->getFirstname());
        $formErrors['lastnameError'] = $this->validateName($student->getLastname());
        $formErrors['genderError'] = $this->validateGender($student->getGender());
        $formErrors['dateOfBirthError'] = $this->validateDate($student->getDateOfBirth());
        $formErrors['emailError'] = $this->validateEmail($student->getEmail(), $student->getId());
        $formErrors['groupNumberError'] = $this->validateGroupNumber($student->getGroupNumber());
        $formErrors['examScoresError'] = $this->validateExamScores($student->getExamScores());
        $formErrors['residenceError'] = $this->validateResidence($student->getResidence());
        return $formErrors;
    }

    private function validateName(?string $input): ?string
    {
        if (empty($input)) {
            return 'Заполните это поле';
        }

        if (!preg_match("/^([а-яё '\-]+)$/ui", $input)) {
            return 'Используйте только кирилицу, дефис, апостров и пробел';
        }

        $inputLength = mb_strlen($input);
        if ($inputLength > 50) {
            return "Используйте не более 50 символов (Вы использовали $inputLength)";
        }

        return null;
    }

    private function validateGender(?string $input): ?string
    {
        if (empty($input)) {
            return 'Отметьте одно значение';
        }

        if ($input !== Student::GENDER_MALE && $input !== Student::GENDER_FEMALE) {
            return 'Некорректное значение';
        }

        return null;
    }

    private function validateDate(?string $input): ?string
    {
        if (empty($input)) {
            return 'Заполните это поле';
        }

        if (!date_create($input)) {
            return 'Некорректное значение';
        }

        return null;
    }

    private function validateEmail(?string $input, ?int $id): ?string
    {
        if (empty($input)) {
            return 'Заполните это поле';
        }

        $inputLength = mb_strlen($input);
        if ($inputLength > 50) {
            return "Используйте не более 50 символов (Вы использовали $inputLength)";
        }

        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'Некорректное значение';
        }

        if ($this->gateway->checkEmail($input, $id) > 0) {
            return 'Данный email уже используется';
        }

        return null;
    }

    private function validateGroupNumber(?string $input): ?string
    {
        if (empty($input)) {
            return 'Заполните это поле';
        }

        if (!preg_match('/^([а-я0-9]+[\-]*)+$/ui', $input)) {
            return 'Используйте только кирилицу, цифры и дефис';
        }

        $inputLength = mb_strlen($input);
        if ($inputLength < 2 || $inputLength > 10) {
            return "Используйте не менее 2 и не более 10 символов (Вы использовали $inputLength)";
        }

        return null;
    }

    private function validateExamScores(?string $input): ?string
    {
        if ($input != 0 && empty($input)) {
            return 'Заполните это поле';
        }

        if (filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 300]]) === false) {
            return 'Общее число баллов ЕГЭ должно быть от 0 до 300';
        }

        return null;
    }

    private function validateResidence(?string $input): ?string
    {
        if (empty($input)) {
            return 'Отметьте одно значение';
        }

        if ($input !== Student::RESIDENCE_RESIDENT && $input !== Student::RESIDENCE_NONRESIDENT) {
            return 'Некорректное значение';
        }

        return null;
    }
}

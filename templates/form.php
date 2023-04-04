<?php

use StudentList\Models\StudentModel\Student;
use StudentList\Helpers\Token;
?>
<div class="container-fluid">
    <a class="link-primary" href="/">⟵ Вернуться к списку</a>
    <h1 class="text-center">Информация о студенте</h1>
    <div class="text-danger fs-5 text-center"><?= $errorMessage ?? '' ?></div>
    <div class="text-success fs-5 text-center"><?= $successMessage ?? '' ?></div>
    <form class="d-flex flex-column" method="POST" action="/form">
        <input type="hidden" name="formToken" value="<?= htmlspecialchars(Token::getToken())?>">
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Имя:</label>
            <input class="form-control border-secondary" type="text" name="firstname" value="<?=  htmlspecialchars($student->getFirstname() ?? '') ?>">
            <div class="text-danger"><?= $errors['firstnameError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Фамилия:</label>
            <input class="form-control border-secondary" type="text" name="lastname" value="<?= htmlspecialchars($student->getLastname() ?? '') ?>">
            <div class="text-danger"><?= $errors['lastnameError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            Пол:
            <label class="form-check-label">
                <input class="form-check-input border-secondary" type="radio" name="gender" value="male" <?= ($student->getGender() === Student::GENDER_MALE) ? 'checked' : '' ?>>
                Мужской
            </label>
            <label class="form-check-label">
                <input class="form-check-input border-secondary" type="radio" name="gender" value="female" <?= ($student->getGender() === Student::GENDER_FEMALE) ? 'checked' : '' ?>>
                Женский
            </label>
            <div class="text-danger"><?= $errors['genderError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Дата рождения:</label>
            <input class="form-control border-secondary" type="date" name="dateOfBirth" value="<?= htmlspecialchars($student->getDateOfBirth() ?? '') ?>">
            <div class="text-danger"><?= $errors['dateOfBirthError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Email:</label>
            <input class="form-control border-secondary" type="email" name="email" value="<?= htmlspecialchars($student->getEmail() ?? '') ?>">
            <div class="text-danger"><?= $errors['emailError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Номер группы:</label>
            <input class="form-control border-secondary" type="text" name="groupNumber" value="<?= htmlspecialchars($student->getGroupNumber() ?? '') ?>">
            <div class="text-danger"><?= $errors['groupNumberError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            <label class="form-label">Суммарное число баллов ЕГЭ:</label>
            <input class="form-control border-secondary" type="number" name="examScores" value="<?= htmlspecialchars($student->getExamScores() ?? '') ?>">
            <div class="text-danger"><?= $errors['examScoresError'] ?? '' ?></div>
        </div>
        <div class="form-group col-md-6 mb-3 mx-auto">
            Проживание:
            <label class="form-check-label">
                <input class="form-check-input border-secondary" type="radio" name="residence" value="resident" <?= ($student->getResidence() === Student::RESIDENCE_RESIDENT) ? 'checked' : '' ?>>
                Местный
            </label>
            <label class="form-check-label">
                <input class="form-check-input border-secondary" type="radio" name="residence" value="nonresident" <?= ($student->getResidence() === Student::RESIDENCE_NONRESIDENT) ? 'checked' : '' ?>>
                Иногородний
            </label>
            <div class="text-danger"><?= $errors['residenceError'] ?? '' ?></div>
        </div>
        <div class="form-group mx-auto">
            <input class="btn btn-outline-primary" type="submit" value="Сохранить">
        </div>
    </form>
</div>
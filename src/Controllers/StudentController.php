<?php

namespace StudentList\Controllers;

use StudentList\Models\StudentModel\{StudentManager, StudentValidator};
use StudentList\Views\View;
use StudentList\Helpers\Token;

class StudentController
{
    protected $repository;
    protected $validator;
    protected $view;

    public function __construct(StudentManager $repository, StudentValidator $validator, View $view)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->view = $view;
    }

    public function getForm(): void
    {
        $id = $this->getFromSession('id');
        $student = $this->repository->getStudent($id);
        if (!empty($_POST)) {
            if (!isset($_POST['formToken']) || $_POST['formToken'] !== Token::getToken('formToken')) {
                $this->view->renderHtml('form', 'default', [
                    'title' => 'Информация о студенте',
                    'student' => $student,
                    'errorMessage' => 'Возникла ошибка! Пожалуйста, повторите отправку.'
                ]);
                return;
            }

            $student->fillFromArray($_POST);

            $errors = $this->validator->validate($student);
            if (array_filter($errors)) {
                $this->view->renderHtml('form', 'default', [
                    'title' => 'Информация о студенте',
                    'student' => $student,
                    'errorMessage' => 'Форма заполнена некорректно! Пожалуйста, исправьте ошибки.',
                    'errors' => $errors
                ]);
                return;
            }

            $this->repository->save($student);
            if (!$id) {
                $this->setToSession('id', $student->getId());
            }
            header('Location: /form');
            exit;
        }

        $this->view->renderHtml('form', 'default', [
            'title' => 'Информация о студенте',
            'student' => $student,
            'successMessage' => ($id) ? 'Все данные сохранены' : ''
        ]);
    }
    
    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(['cookie_lifetime' => 315532800, 'cookie_httponly' => true, 'cookie_samesite' => 'Strict']);
        }
    }

    private function getFromSession(string $key): mixed
    {
        $this->startSession();
        return $_SESSION[$key] ?? null;
    }

    private function setToSession(string $key, mixed $value): void
    {
        $this->startSession();
        $_SESSION[$key] = $value;
    }
}

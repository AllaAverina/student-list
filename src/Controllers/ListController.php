<?php

namespace StudentList\Controllers;

use StudentList\Models\StudentModel\StudentManager;
use StudentList\Helpers\Paginator;
use StudentList\Views\View;

class ListController
{
    protected $repository;
    protected $paginator;
    protected $view;

    public function __construct(StudentManager $repository, Paginator $paginator, View $view)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->view = $view;
    }

    public function getListForPage(int $currentPage = 1): void
    {
        $itemsPerPage = 30;
        $students = $this->repository->getStudentList($currentPage, $itemsPerPage, $_GET);

        if ($students == null && $currentPage != 1) {
            $this->view->renderError(404);
        }

        $search = $_GET['search'] ?? '';
        $this->paginator->setCurrentPage($currentPage);
        $this->paginator->setLastPage($itemsPerPage, $search);
        $this->paginator->setDiff(2);

        $this->view->renderHtml('list', 'default', [
            'title' => 'Список студентов',
            'students' => $students,
            'paginator' => $this->paginator,
            'search' => $search
        ]);
    }
}

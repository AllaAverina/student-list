<?php

namespace StudentList\DI;

use StudentList\Database\Connection;
use StudentList\Models\StudentModel\{StudentGateway, StudentValidator, StudentManager};
use StudentList\Helpers\Paginator;
use StudentList\Views\View;
use StudentList\Controllers\{ListController, StudentController};

class Container
{
    private $services = [];
    private $functions;

    public function __construct()
    {
        $this->functions = [
            'mysqlConfig' => function () {
                return (require __DIR__ . '/../../config/config.php')['mysql'];
            },
            'routes' => function () {
                return require __DIR__ . '/../../config/routes.php';
            },
            Connection::class => function () {
                return new Connection($this->get('mysqlConfig'));
            },
            StudentGateway::class => function () {
                return new StudentGateway($this->get(Connection::class));
            },
            StudentValidator::class => function () {
                return new StudentValidator($this->get(StudentGateway::class));
            },
            StudentManager::class => function () {
                return new StudentManager($this->get(StudentGateway::class));
            },
            Paginator::class => function () {
                return new Paginator($this->get(StudentGateway::class));
            },
            View::class => function () {
                return new View();
            },
            ListController::class => function () {
                return new ListController(
                    $this->get(StudentManager::class),
                    $this->get(Paginator::class),
                    $this->get(View::class)
                );
            },
            StudentController::class => function () {
                return new StudentController(
                    $this->get(StudentManager::class),
                    $this->get(StudentValidator::class),
                    $this->get(View::class)
                );
            },
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            return $this->services[$id];
        }
        $service = $this->functions[$id]();
        $this->services[$id] = $service;
        return $service;
    }
}

<?php

use StudentList\Routing\Router;
use StudentList\DI\Container;
use StudentList\Views\View;

//настройки для разработки
ini_set('display_errors', 1);
ini_set('log_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

set_exception_handler(function ($e) {
    error_log($e->getMessage(), 0);
    (new View)->renderError(500);
});

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
(new Router(new Container))->run($route);

<?php

namespace StudentList\Routing;

use StudentList\DI\Container;
use StudentList\Views\View;

class Router
{
    private $container;
    private $routes;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routes = $container->get('routes');
    }

    public function run(string $route): void
    {
        $way = $this->getWay($route);

        if (!$way) {
            $this->container->get(View::class)->renderError(404);
        }

        $controllerName = $way['controller'];
        $actionName = $way['action'];
        $params = $way['params'];

        $controller = $this->container->get($controllerName);
        $controller->$actionName(...$params);
    }

    public function getWay(string $route): ?array
    {
        foreach ($this->routes as $pattern => ['controller' => $controller, 'action' => $action]) {
            if (preg_match($pattern, $route, $matches)) {
                array_shift($matches);
                return ['controller' => $controller, 'action' => $action, 'params' => $matches];
            }
        }
        return null;
    }
}

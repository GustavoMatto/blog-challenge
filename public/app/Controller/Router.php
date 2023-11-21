<?php

namespace Desafiobis2bis\App\Controller;

use Desafiobis2bis\App\Controller\HomeController;
use Desafiobis2bis\App\Controller\RouteDefinition\RouteDefinitionInterface;
use Desafiobis2bis\App\View\DefaultView;

class Router 
{
    private $controller;
    private $routeDefinition;
    private DefaultView $defaultView;

    public function __construct($controller, RouteDefinitionInterface $routeDefinition, DefaultView $defaultView) {
        $this->controller = $controller;
        $this->routeDefinition = $routeDefinition;
        $this->defaultView = $defaultView;
    }

    public function getRoute() {
        $routes = $this->routeDefinition->getRoutes();
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    
        if (isset($routes[$uri])) {
            $route = $routes[$uri];
            $controllerClass = $route['controller'];
            $action = $route['action'];

            $controller = new $controllerClass($this->defaultView);
            $controller->$action();
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }
}
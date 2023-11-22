<?php

namespace Desafiobis2bis\App\Controller;

use Desafiobis2bis\App\Controller\DefaultController;
use Desafiobis2bis\App\Controller\RouteDefinition\RouteDefinitionInterface;
use Desafiobis2bis\App\View\DefaultView;

class Router 
{
    protected DefaultController $controller;
    protected RouteDefinitionInterface $routeDefinition;
    protected DefaultView $defaultView;

    public function __construct
    (
        DefaultController $controller,
        RouteDefinitionInterface $routeDefinition,
        DefaultView $defaultView
    ) {
        $this->controller = $controller;
        $this->routeDefinition = $routeDefinition;
        $this->defaultView = $defaultView;
    }

    public function getRoute() {
        $routes = $this->routeDefinition->getRoutes();
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    
        if (isset($routes[$uri])) {
            $route = $routes[$uri];
            $action = $route['action'];

            $this->controller->$action();
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }
}
<?php

namespace Desafiobis2bis\App\Controller\RouteDefinition;

use Desafiobis2bis\App\Controller\RouteDefinition\RouteDefinitionInterface;
use Desafiobis2bis\App\Controller\HomeController;

class DefaultRouteDefinition implements RouteDefinitionInterface {
    public function getRoutes(): array {
        return [
            '/' => [
                'controller' => HomeController::class,
                'action' => 'index',
            ],
            '/post' => [
                'controller' => HomeController::class,
                'action' => 'post'
            ],
            '/sobre' => [
                'controller' => HomeController::class,
                'action' => 'aboutUs'
            ],
            '/register' => [
                'controller' => HomeController::class,
                'action' => 'register'
            ],
            '/login' => [
                'controller' => HomeController::class,
                'action' => 'login'
            ],
            '/dashboard' => [
                'controller' => HomeController::class,
                'action' => 'dashboard'
            ],
        ];
    }
}

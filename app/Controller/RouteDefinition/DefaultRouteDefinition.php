<?php

namespace Desafiobis2bis\App\Controller\RouteDefinition;

use Desafiobis2bis\App\Controller\RouteDefinition\RouteDefinitionInterface;

class DefaultRouteDefinition implements RouteDefinitionInterface 
{
    public function getRoutes(): array 
    {
        return [
            '/' => [
                'action' => 'index'
            ],
            '/post' => [
                'action' => 'post'
            ],
            '/sobre' => [
                'action' => 'aboutUs'
            ],
            '/register' => [
                'action' => 'register'
            ],
            '/login' => [
                'action' => 'login'
            ],
            '/logout' => [
                'action' => 'logout'
            ],
            '/dashboard' => [
                'action' => 'dashboard'
            ],
            '/account' => [
                'action' => 'account'
            ],
            '/adminPostPage' => [
                'action' => 'adminPostPage'
            ],
            '/adminUserPage' => [
                'action' => 'adminUserPage'
            ],
            '/adminPage' => [
                'action' => 'adminPage'
            ]
        ];
    }
}

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Desafiobis2bis\App\Controller\Router;
use Desafiobis2bis\App\Controller\DefaultController;
use Desafiobis2bis\App\Controller\RouteDefinition\DefaultRouteDefinition; 
use Desafiobis2bis\App\View\DefaultView;
use Desafiobis2bis\App\Model\User;
use Desafiobis2bis\App\Model\Config\Database;

$router = new Router(
    new DefaultController(new DefaultView()),
    new DefaultRouteDefinition(), new DefaultView()
);

$router->getRoute();

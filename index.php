<?php

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

require 'src/Router.php';
$router = new Router;

$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);

$params = $router->match($path);

if($params === false) {
  exit('no route for this path');
}

$controller = $params['controller'];
$action = $params['action'];

require 'src/Controllers/' . $controller . '.php';

$controllerObject = new $controller;
$controllerObject->$action();

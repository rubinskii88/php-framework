<?php

require __DIR__ . '/config/debug.php';

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

function autoload($className)
{
  
  $path = str_replace('\\', '/', $className);
  
  require __DIR__ . '/src/' . $path . '.php';
}

spl_autoload_register('autoload');

// require 'src/Router.php';
$router = new Framework\Router;

$router->add('/{controller}/{action}');
// $router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
// $router->add('/products', ['controller' => 'Products', 'action' => 'index']);
// $router->add('/', ['controller' => 'Home', 'action' => 'index']);

$params = $router->match($path);

if($params === false) {
  exit('no route for this path');
}

$controller = 'App\Controllers\\' . ucwords($params['controller']);
$action = $params['action'];

// require 'src/Controllers/' . $controller . '.php';

$controllerObject = new $controller;
$controllerObject->$action();

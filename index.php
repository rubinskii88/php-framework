<?php

declare(strict_types=1);

require __DIR__ . '/config/debug.php';

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

function autoload($className)
{

  $path = str_replace('\\', '/', $className);

  require __DIR__ . '/src/' . $path . '.php';
}

spl_autoload_register('autoload');

$router = new Framework\Router;

$router->add('/admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('/{title:\w+}/{id:\d+}/{page:\d+}', ['controller' => 'products', 'action' => 'showPage']);
$router->add('/product/{slug:[\w-]+}', ['controller' => 'Products', 'action' => 'show']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/{controller}/{action}');

$container = new Framework\Container;

// $database = new App\Database('192.168.1.59', 'product_db', 'product_db_user', 'secret');

$container->set(App\Database::class, function () {
  return new App\Database('192.168.1.59', 'product_db', 'product_db_user', 'secret');
});

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);

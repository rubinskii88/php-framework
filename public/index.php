<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/config/autoload.php';

$dotenv = new Framework\Dotenv;
$dotenv->load(ROOT_PATH . '/.env');

set_error_handler('Framework\ErrorHandler::handleError');
set_exception_handler('Framework\ErrorHandler::handleException');

require ROOT_PATH . '/config/debug.php';

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

if ($path === false) {
  throw new UnexpectedValueException(
    "malformed url - {$_SERVER['REQUEST_URI']}"
  );
}

$router = require ROOT_PATH . '/config/routes.php';

$container = require ROOT_PATH . '/config/services.php';

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);

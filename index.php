<?php

declare(strict_types=1);

require 'config/autoload.php';

$dotenv = new Framework\Dotenv;
$dotenv->load('.env');

set_error_handler('Framework\ErrorHandler::handleError');
set_exception_handler('Framework\ErrorHandler::handleException');

require __DIR__ . '/config/debug.php';

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

if ($path === false) {
  throw new UnexpectedValueException(
    "malformed url - {$_SERVER['REQUEST_URI']}"
  );
}

$router = require 'config/routes.php';

$container = require 'config/services.php';

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);

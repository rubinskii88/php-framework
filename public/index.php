<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/config/autoload.php';

$dotenv = new Framework\Dotenv;
$dotenv->load(ROOT_PATH . '/.env');

set_error_handler('Framework\ErrorHandler::handleError');
set_exception_handler('Framework\ErrorHandler::handleException');

require ROOT_PATH . '/config/debug.php';

$router = require ROOT_PATH . '/config/routes.php';

$container = require ROOT_PATH . '/config/services.php';

$dispatcher = new Framework\Dispatcher($router, $container);

$request = Framework\Request::createFromGlobals();

$response = $dispatcher->handle($request);
$response->send();

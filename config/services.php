<?php

$container = new Framework\Container;

$container->set(App\Database::class, function () {
  return new App\Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
  );
});

$container->set(Framework\ViewInterface::class, function () {
  return new Framework\View;
});

return $container;

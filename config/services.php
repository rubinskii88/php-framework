<?php

$container = new Framework\Container;

// $database = new App\Database('192.168.1.59', 'product_db', 'product_db_user', 'secret');

$container->set(App\Database::class, function () {
  return new App\Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
  );
});

return $container;
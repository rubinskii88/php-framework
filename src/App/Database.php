<?php

namespace App;

use PDO;

class Database
{
  public function getConnection(): PDO
  {
    $dsn = 'mysql:host=192.168.1.59;dbname=product_db;charset=utf8mb4;port=3306';

    return new PDO($dsn, 'product_db_user', 'secret', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }
}

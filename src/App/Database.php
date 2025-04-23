<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{

  public function __construct(
    private string $host,
    private string $dbName,
    private string $user,
    private string $password
  ) {
    // echo 'created db obj';
  }
  public function getConnection(): PDO
  {
    // $dsn = 'mysql:host=192.168.1.59;dbname=product_db;charset=utf8mb4;port=3306';
    // 'product_db_user', 'secret'
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8mb4;port=3306';

    return new PDO($dsn, $this->user, $this->password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }
}

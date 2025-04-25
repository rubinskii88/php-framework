<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
  private ?PDO $pdo = null;

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
    if ($this->pdo === null) {
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8mb4;port=3306';

      $this->pdo = new PDO($dsn, $this->user, $this->password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    }

    return $this->pdo;
  }
}

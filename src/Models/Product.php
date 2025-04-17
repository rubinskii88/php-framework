<?php

class Product
{
  public function getData(): array
  {
    $dsn = 'mysql:host=192.168.1.59;dbname=product_db;charset=utf8mb4;port=3306';

    $pdo = new PDO($dsn, 'product_db_user', 'secret', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query('SELECT * FROM product');

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

<?php

declare(strict_types=1);

namespace Framework;

use PDO;

use App\Database;

abstract class Model
{
  protected $tableName;

  protected array $errors = [];

  public function __construct(protected Database $database) {}

  protected function addError(string $field, string $message): void
  {
    $this->errors[$field] = $message;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  private function getTableName(): string
  {

    if ($this->tableName !== null) {
      return $this->tableName;
    }
    $parts = explode('\\', $this::class);

    $tableName = array_pop($parts);

    return strtolower($tableName);
  }

  public function getInsertedId(): string
  {
    $conn = $this->database->getConnection();

    return $conn->lastInsertId();
  }

  public function findAll(): array
  {
    $pdo = $this->database->getConnection();

    $sql = "SELECT * FROM {$this->getTableName()}";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find(string $id): array|bool
  {
    $conn = $this->database->getConnection();

    $sql = "SELECT *
            FROM {$this->getTableName()}
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert(array $data): bool
  {
    $this->validate($data);

    if (!empty($this->errors)) {
      return false;
    }

    $columns = array_keys($data);
    $columns = implode(', ', $columns);

    $placeholders = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO {$this->getTableName()} ({$columns}) 
            VALUES ({$placeholders})";

    $conn = $this->database->getConnection();

    $stmt = $conn->prepare($sql);

    $i = 1;

    foreach ($data as $value) {
      $type = match (gettype($value)) {
        'boolean' => PDO::PARAM_BOOL,
        'integer' => PDO::PARAM_INT,
        'NULL' => PDO::PARAM_NULL,
        default => PDO::PARAM_STR
      };

      $stmt->bindValue($i++, $value, $type);
    }

    return $stmt->execute();
  }

  public function update(string $id, array $data): bool
  {
    $this->validate($data);

    if (!empty($this->errors)) {
      return false;
    }

    $sql = "UPDATE {$this->getTableName()} ";

    unset($data['id']);

    $assignments = array_keys($data);

    array_walk($assignments, function (&$value) {
      $value = "{$value} = ?";
    });

    $sql .= "SET " . implode(', ', $assignments);

    $sql .= " WHERE id = ?";

    $conn = $this->database->getConnection();

    $stmt = $conn->prepare($sql);

    $i = 1;

    foreach ($data as $value) {
      $type = match (gettype($value)) {
        'boolean' => PDO::PARAM_BOOL,
        'integer' => PDO::PARAM_INT,
        'NULL' => PDO::PARAM_NULL,
        default => PDO::PARAM_STR
      };

      $stmt->bindValue($i++, $value, $type);
    }
    
    $stmt->bindValue($i, $id, PDO::PARAM_INT);

    return $stmt->execute();
  }
  
  public function delete(string $id): bool
  {
    $sql = "DELETE FROM {$this->getTableName()}
            WHERE id =:id";
    
    $conn = $this->database->getConnection();

    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
    return $stmt->execute();
  }

  abstract protected function validate(array $data): void;
}

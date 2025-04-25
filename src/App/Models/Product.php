<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Model;

use PDO;

class Product extends Model
{

  protected function validate(array $data): void
  {
    if (empty($data['name'])) {
      $this->addError('name', 'name is required');
    }
  }

  public function getTotalRows(): int
  {
    $sql = "SELECT COUNT(*) AS total
            FROM product";

    $conn = $this->database->getConnection();

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $row['total'];
  }
}

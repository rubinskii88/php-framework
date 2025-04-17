
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>

<body>
  <h1>
    Products
  </h1>
  <?php foreach ($products as $product): ?>
    <h2>
      <?= $product['name']; ?>
    </h2>
    <p>
      <?= $product['description']; ?>
    </p>
  <?php endforeach; ?>
</body>

</html>
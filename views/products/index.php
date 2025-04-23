

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

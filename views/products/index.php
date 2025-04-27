<?php require __DIR__ . '/../shared/header.php' ?>

<h1>
  Products
</h1>
<a href="/products/new">
  create new product
</a>
<p>
  total rows: <?= $totalRows; ?>
</p>
<?php foreach ($products as $product): ?>
  <h2>
    <a href="/products/<?= $product['id'] ?>/show">
      <?= $product['name']; ?>
    </a>
  </h2>
  <p>
    <?= $product['description']; ?>
  </p>
<?php endforeach; ?>
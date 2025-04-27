<?php require __DIR__ . '/../shared/header.php' ?>

<h3>
  <?= $product['name'] ?>
</h3>
<p>
  <?= $product['description'] ?>
</p>
<p>
  <a href="/products/<?= $product["id"] ?>/edit">
    edit product
  </a>
</p>
<p>
  <a href="/products/<?= $product["id"] ?>/delete">
    delete product
  </a>
</p>
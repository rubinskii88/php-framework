<?php require __DIR__ . '/../shared/header.php' ?>

<h2>
  delete product
</h2>
<p>
  <a href="/products/<?= $product["id"] ?>/show">
    back to product
  </a>
</p>
<form
  method="post"
  action="/products/<?= $product['id'] ?>/destroy">
  <p>
    delete product?
  </p>
  <input type="submit" value="delete">
</form>
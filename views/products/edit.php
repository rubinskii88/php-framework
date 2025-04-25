<h2>
  edit product
</h2>
<p>
  <a href="/products/<?= $product["id"] ?>/show">
    back to product
  </a>
</p>
<form
  method="post"
  action="/products/<?= $product['id'] ?>/update">
  <?php require 'form.php' ?>
</form>
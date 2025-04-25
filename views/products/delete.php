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
  action="/products/<?= $product['id'] ?>/delete">
  <p>
    delete product?
  </p>
  <input type="submit" value="delete">
</form>
<input
  type="text"
  name="name"
  value="<?= $product['name'] ?? '' ?>"
  placeholder="name">
<br>
<?php if (isset($errors['name'])): ?>
  <p>
    <?= $errors['name'] ?>
  </p>
<?php endif; ?>
<br>
<textarea
  name="description"
  placeholder="description"><?= $product['description'] ?? '' ?>
</textarea>
<br>
<input type="submit" value="save">
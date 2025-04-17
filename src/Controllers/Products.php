<?php

class Products
{
  public function index()
  {
    require __DIR__ . '/../Models/Product.php';

    $model = new Product;

    $products = $model->getData();

    require __DIR__ . '/../../views/products_index.php';
  }
  
  public function show()
  {
    require __DIR__ . '/../../views/products_show.php';
  }
}

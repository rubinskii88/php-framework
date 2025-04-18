<?php

namespace App\Controllers;
use App\Models\Product;

class Products
{
  public function index()
  {

    $model = new Product;

    $products = $model->getData();

    require __DIR__ . '/../../../views/products_index.php';
  }
  
  public function show()
  {
    require __DIR__ . '/../../../views/products_show.php';
  }
}

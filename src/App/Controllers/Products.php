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
  
  public function show(string $id)
  {
    
    var_dump($id);
    require __DIR__ . '/../../../views/products_show.php';
  }
  
  public function showPage(string $title, string $id, string $page)
  {
    d($title, $id, $page);
  }
}

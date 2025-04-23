<?php

namespace App\Controllers;
use App\Models\Product;

use Framework\View;

class Products
{
  public function index()
  {

    $model = new Product;

    $products = $model->getData();
    
    $view = new View;

    echo $view->render('shared/header', ['title' => 'all products']);
    
    echo $view->render('products/index', [
      'products' => $products
    ]);
  }
  
  public function show(string $id)
  {
    
    $view = new View;
    
    echo $view->render('shared/header');
    
    echo $view->render('products/show', [
      'id' => $id
    ]);
  }
  
  public function showPage(string $title, string $id, string $page)
  {
    d($title, $id, $page);
  }
}

<?php

namespace App\Controllers;
use App\Models\Product;

use Framework\View;

class Products
{
  
  public function __construct(
    private View $view,
    private Product $model
    )
  {
    
  }
  public function index()
  {


    $products = $this->model->getData();
    

    echo $this->view->render('shared/header', ['title' => 'all products']);
    
    echo $this->view->render('products/index', [
      'products' => $products
    ]);
  }
  
  public function show(string $id)
  {
    

    
    echo $this->view->render('shared/header');
    
    echo $this->view->render('products/show', [
      'id' => $id
    ]);
  }
  
  public function showPage(string $title, string $id, string $page)
  {
    d($title, $id, $page);
  }
}

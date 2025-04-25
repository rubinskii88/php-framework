<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;

class Products extends Controller
{

  public function __construct(
    private Product $model
  ) {}

  public function index()
  {
    $products = $this->model->findAll();

    echo $this->view->render('shared/header', ['title' => 'all products']);

    echo $this->view->render('products/index', [
      'products' => $products,
      'totalRows' => $this->model->getTotalRows()
    ]);
  }

  public function show(string $id)
  {
    $product = $this->getProduct($id);

    echo $this->view->render('shared/header', [
      'title' => 'show product ' . $product['id']
    ]);

    echo $this->view->render('products/show', [
      'product' => $product
    ]);
  }

  public function edit(string $id)
  {
    $product = $this->getProduct($id);

    echo $this->view->render('shared/header', [
      'title' => 'edit product ' . $product['id']
    ]);

    echo $this->view->render('products/edit', [
      'product' => $product
    ]);
  }

  public function new()
  {
    echo $this->view->render('shared/header', [
      'title' => 'add new product'
    ]);

    echo $this->view->render('products/new');
  }

  public function create()
  {
    $data = [
      'name' => $this->request->post['name'],
      'description' => $this->request->post['description'] ?? null
    ];

    if ($this->model->insert($data)) {
      header("Location: /products/{$this->model->getInsertedId()}/show");
      exit;
    } else {
      echo $this->view->render('shared/header', [
        'title' => 'add new product'
      ]);

      echo $this->view->render('products/new', [
        'errors' => $this->model->getErrors(),
        'product' => $data
      ]);
    }
  }

  public function update(string $id)
  {
    $product = $this->getProduct($id);

    $product["name"] = $this->request->post["name"];
    $product["description"] = empty($this->request->post["description"]) ? null : $this->request->post["description"];

    if ($this->model->update($id, $product)) {
      header("Location: /products/{$id}/show");
      exit;
    } else {

      echo $this->view->render("shared/header", [
        "title" => "edit product"
      ]);

      echo $this->view->render("products/edit", [
        "errors" => $this->model->getErrors(),
        "product" => $product
      ]);
    }
  }

  public function delete(string $id): void
  {
    $product = $this->getProduct($id);

    echo $this->view->render("shared/header", [
      "title" => "delete product"
    ]);

    echo $this->view->render("products/delete", [
      "product" => $product
    ]);
  }

  private function getProduct(string $id): array
  {
    $product = $this->model->find($id);

    if ($product === false) {
      throw new PageNotFoundException("Product not found");
    }

    return $product;
  }
  public function showPage(string $title, string $id, string $page)
  {
    d($title, $id, $page);
  }

  public function destroy(string $id)
  {
    $product = $this->getProduct($id);

    $this->model->delete($id);

    header("Location: /products/index");
    exit;
  }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;
use Framework\Response;

class Products extends Controller
{

  public function __construct(
    private Product $model
  ) {}

  public function index(): Response
  {
    $products = $this->model->findAll();

    return $this->view('products/index', [
      'title' => 'all products',
      'products' => $products,
      'totalRows' => $this->model->getTotalRows()
    ]);
  }

  public function show(string $id): Response
  {
    $product = $this->getProduct($id);

    return $this->view('products/show', [
      'title' => "show product {$product['id']}",
      'product' => $product
    ]);
  }

  public function edit(string $id): Response
  {
    $product = $this->getProduct($id);

    return $this->view('products/edit', [
      'title' => "edit product {$product['id']}",
      'product' => $product
    ]);
  }

  public function new(): Response
  {
    return $this->view('products/new', [
      'title' => 'add new product'
    ]);
  }

  public function create(): Response
  {
    $data = [
      'name' => $this->request->post['name'],
      'description' => $this->request->post['description'] ?? null
    ];

    if ($this->model->insert($data)) {

      return $this->redirect("/products/{$this->model->getInsertedId()}/show");
    } else {

      return $this->view('products/new', [
        'title' => 'add new product',
        'errors' => $this->model->getErrors(),
        'product' => $data
      ]);
    }
  }

  public function update(string $id): Response
  {
    $product = $this->getProduct($id);

    $product["name"] = $this->request->post["name"];
    $product["description"] = empty($this->request->post["description"]) ? null : $this->request->post["description"];

    if ($this->model->update($id, $product)) {
      return $this->redirect("/products/{$id}/show");
    } else {

      return $this->view("products/edit", [
        "title" => "edit product",
        "errors" => $this->model->getErrors(),
        "product" => $product
      ]);
    }
  }

  public function delete(string $id): Response
  {
    $product = $this->getProduct($id);

    return $this->view("products/delete", [
      "title" => "delete product",
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

  public function destroy(string $id): Response
  {
    $product = $this->getProduct($id);

    $this->model->delete($id);

    return $this->redirect("/products/index");
  }

  public function responseCodeExample(): Response
  {
    $this->response->setStatusCode(451);

    $this->response->setBody('unavaliable for legal reasons');

    return $this->response;
  }
}

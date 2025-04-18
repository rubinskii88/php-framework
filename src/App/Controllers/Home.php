<?php

namespace App\Controllers;

class Home
{
  public function index() {
    require __DIR__ . '/../../../views/home_index.php';
  }
}
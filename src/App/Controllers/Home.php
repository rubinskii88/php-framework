<?php

namespace App\Controllers;

use Framework\View;

class Home
{
  public function index() {
    $view = new View;

    echo $view->render('home/index');
  }
}
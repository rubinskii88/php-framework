<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Controller;

class Home extends Controller
{
  public function index()
  {
    echo $this->view->render('home/index');
  }
}

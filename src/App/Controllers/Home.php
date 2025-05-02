<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Controller;
use Framework\Response;

class Home extends Controller
{
  public function index(): Response
  {
    return $this->view('home/index', [
      'title' => 'main page',

    ]);
  }
}

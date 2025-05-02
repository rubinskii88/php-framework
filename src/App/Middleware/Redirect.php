<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;

class Redirect implements MiddlewareInterface
{

  public function __construct(private Response $response) {}

  public function process(Request $request, RequestHandlerInterface $next): Response
  {
    $this->response->redirect('/products/index');

    return $this->response;
  }
}

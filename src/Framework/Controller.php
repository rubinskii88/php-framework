<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
  protected Request $request;
  protected Response $response;

  protected ViewInterface $view;

  public function setRequest(Request $request): void
  {
    $this->request = $request;
  }

  public function setResponse(Response $response): void
  {
    $this->response = $response;
  }

  public function setView(ViewInterface $view): void
  {
    $this->view = $view;
  }

  protected function view(string $template, array $data = []): Response
  {
    $this->response->setBody($this->view->render($template, $data));

    return $this->response;
  }
  
  protected function redirect(string $url): Response
  {
    $this->response->redirect($url);
    
    return $this->response;
  }
}

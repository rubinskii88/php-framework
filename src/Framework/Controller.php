<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
  protected Request $request;
  protected View $view;

  public function setRequest(Request $request): void
  {
    $this->request = $request;
  }
  
  public function setView(View $view): void
  {
    $this->view = $view;
  }
}

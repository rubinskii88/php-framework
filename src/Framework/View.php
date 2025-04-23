<?php

namespace Framework;

class View
{
  public function render(string $template, array $data = []): string
  {
    extract($data, EXTR_SKIP);

    ob_start();
    require __DIR__ . '/../../views/' . $template . '.php';

    return ob_get_clean();
  }
}

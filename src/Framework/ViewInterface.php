<?php

namespace Framework;

interface ViewInterface
{
  public function render(string $template, array $data = []): string;
}
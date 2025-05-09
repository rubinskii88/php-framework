<?php

declare(strict_types=1);

namespace Framework;

interface RequestHandlerInterface
{
  public function handle(Request $request): Response;
}
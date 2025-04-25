<?php

declare(strict_types=1);

namespace Framework;

class Router
{

  private array $routes = [];

  public function add(string $path, array $params = []): void
  {
    $this->routes[] = [
      'path' => $path,
      'params' => $params
    ];
  }

  public function match(string $path, string $method): array|bool
  {

    $path = urldecode($path);

    $path = trim($path, '/');

    foreach ($this->routes as $route) {

      $pattern = $this->getPatternFromRoutePath($route['path']);

      if (preg_match($pattern, $path, $matches)) {
        $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        $params = array_merge($matches, $route['params']);

        if (array_key_exists('method', $params)) {
          if (strtolower($method) !== strtolower($params['method'])) {
            continue;
          }
        }

        return $params;
      }
    }

    return false;
  }

  private function getPatternFromRoutePath(string $routePath): string
  {

    $routePath = trim($routePath, '/');



    $segments = explode('/', $routePath);

    // dd($segments);

    $segments = array_map(
      function (string $segment): string {
        // dd($segment);
        if (preg_match('#^\{([a-z][a-z0-9]*)\}$#', $segment, $matches)) {
          return '(?<' . $matches[1] . '>[^/]*)';
        }

        if (preg_match('#^\{([a-z][a-z0-9]*):(.+)\}$#', $segment, $matches)) {
          return '(?<' . $matches[1] . '>' . $matches[2] . ')';
        }

        return $segment;
      },
      $segments
    );

    // dd($segments);

    $pattern = '#^' . implode('/', $segments) . '$#iu';

    // dd($pattern);

    return $pattern;
  }
}

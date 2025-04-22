<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
  public function __construct(private Router $router) {}

  public function handle(string $path)
  {


    $params = $this->router->match($path);

    if ($params === false) {
      exit('no route for this path');
    }

    $controller = $this->getControllerName($params);
    $action = $this->getActionName($params);

    
    
    $controllerObject = new $controller;
    

    $args = $this->getActionArguments($controller, $action, $params);

    $controllerObject->$action(...$args);
  }

  private function getActionArguments(string $controller, string $action, array $params): array
  {
    $method = new ReflectionMethod($controller, $action);

    $args = [];

    foreach ($method->getParameters() as $parameter) {
      $name = $parameter->getName();

      $args[$name] = $params[$name];
    }

    return $args;
  }

  private function getControllerName(array $params): string
  {
    $controller = $params['controller'];
    $controller = strtolower($controller);
    $controller = ucwords($controller, '-');
    $controller = str_replace('-', '', $controller);

    $namespace = 'App\Controllers';

    if (array_key_exists('namespace', $params)) {
      $namespace .= '\\' . $params['namespace'];
    }

    // dd($namespace . '\\' . $controller);
    
    return $namespace . '\\' . $controller;
  }

  private function getActionName(array $params): string
  {
    $action = $params['action'];
    $action = strtolower($action);
    $action = ucwords($action, '-');
    $action = str_replace('-', '', $action);
    $action = lcfirst($action);

    return $action;
  }
}

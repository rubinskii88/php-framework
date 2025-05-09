<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\PageNotFoundException;
use UnexpectedValueException;
use ReflectionMethod;

class Dispatcher
{
  public function __construct(
    private Router $router,
    private Container $container,
    private array $middlewareClasses
  ) {}

  public function handle(Request $request): Response
  {
    $path = $this->getPath($request->uri);

    $params = $this->router->match($path, $request->method);

    if ($params === false) {
      throw new PageNotFoundException("no route for {$path} and method {$request->method}");
    }

    $controller = $this->getControllerName($params);
    $action = $this->getActionName($params);

    $controllerObject = $this->container->get($controller);

    $controllerObject->setResponse($this->container->get(Response::class));

    $controllerObject->setView($this->container->get(ViewInterface::class));

    $args = $this->getActionArguments($controller, $action, $params);

    $controllerRequestHandler = new ControllerRequestHandler(
      $controllerObject,
      $action,
      $args
    );

    $middleware = $this->getMiddleware($params);

    $middlewareRequestHandler = new MiddlewareRequestHandler(
      $middleware,
      $controllerRequestHandler
    );

    return $middlewareRequestHandler->handle($request);
  }

  public function getPath(string $uri): string
  {
    $path = parse_url($uri, PHP_URL_PATH);

    if ($path === false) {
      throw new UnexpectedValueException(
        "malformed url - {$uri}"
      );
    }

    return $path;
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

  private function getMiddleware(array $params): array
  {
    if (!array_key_exists('middleware', $params)) {
      return [];
    }

    $middleware = explode('|', $params['middleware']);

    array_walk($middleware, function (&$value) {
      if(!array_key_exists($value, $this->middlewareClasses)) {
        throw new UnexpectedValueException("middleware {$value} not found in config");
      }
      
      $value = $this->container->get($this->middlewareClasses[$value]);
    });

    return $middleware;
  }

  // private function getMiddleware(array $params): array
  // {
  //   if (!array_key_exists('middleware', $params)) {
  //     return [];
  //   }

  //   $middleware = explode('|', $params['middleware']);

  //   array_walk($middleware, function (&$value) {
  //     if (!isset($this->middlewareClasses[$value])) {
  //       throw new \RuntimeException("Middleware '{$value}' is not defined in config.");
  //     }

  //     $value = $this->container->get($this->middlewareClasses[$value]);
  //   });

  //   return $middleware;
  // }
}

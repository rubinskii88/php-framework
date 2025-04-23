<?php

declare(strict_types=1);

namespace Framework;

use Closure;
use ReflectionClass;
use ReflectionNamedType;

class Container
{

  // список зарегистированных 
  private array $registry = [];

  public function set(string $name, Closure $value): void
  {
    $this->registry[$name] = $value;
  }

  // получение объекта и всех его зависимостей
  public function get(string $className): object
  {

    if (array_key_exists($className, $this->registry)) {
      return $this->registry[$className]();
    }


    $reflector = new ReflectionClass($className);

    $constructor = $reflector->getConstructor();

    $dependencies = [];

    if ($constructor === null) {
      return new $className;
    }

    foreach ($constructor->getParameters() as $parameter) {
      // $type = (string) $parameter->getType();
      $type = $parameter->getType();
      
      if($type === null) {
        dd("
          constructor param {$parameter->getName()}
          in class {$className}
          has no type declared
        ");
      }
      
      if( ! $type instanceof ReflectionNamedType) {
        dd("
          constructor param {$parameter->getName()}
          in class {$className}
          has invalid type {$type}
          only single named types supported
        ");
      }
      
      if($type->isBuiltin()) {
        dd('unable to resolve constructor param - ' . $parameter->getName() . ' of type - ' . $type . ' in ' . $className);
      }
      
      $dependencies[] = $this->get((string) $type);
    }

    return new $className(...$dependencies);

    // $controllerObject = new $className(...$dependencies);

    // return $controllerObject;
  }
}

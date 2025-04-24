<?php

function autoload($className)
{

  $path = str_replace('\\', '/', $className);

  require __DIR__ . '/../src/' . $path . '.php';
}

spl_autoload_register('autoload');

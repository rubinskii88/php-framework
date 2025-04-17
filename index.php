<?php

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);

$segments = explode('/', $path);

$controller = $segments[1];
$action = $segments[2];

require 'src/Controllers/'. $controller .'.php';

$controllerObject = new $controller;
$controllerObject->$action();

<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/core/basics.php';
require __DIR__ . '/../src/routes.php';

$router->run($router->routes);

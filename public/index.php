<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('DIR_IMG', 'public' . DS . 'img' . DS);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/core/basics.php';
require __DIR__ . '/../src/routes.php';

$router->run($router->routes);

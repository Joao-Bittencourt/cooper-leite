<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('DIR_IMG', 'public' . DS . 'img' . DS);

require './vendor/autoload.php';
require './src/core/basics.php';
require './src/routes.php';

$router->run($router->routes);

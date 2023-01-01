<?php

require './vendor/autoload.php';
require './src/core/basics.php';
require './src/routes.php';

$router->run($router->routes);

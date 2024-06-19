<?php

// @ToDo: revisar, verificar um local melhor para inicializar a sessão
if (getenv('ENVIRONMENT') == 'DOCKER') {
    ini_set('session.save_handler', 'redis');
    ini_set('session.save_path', 'tcp://redis:6379?prefix=cooper_leite_dev_');
}

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/core/basics.php';
require_once __DIR__ . '/../src/routes.php';

$router->run($router->routes);

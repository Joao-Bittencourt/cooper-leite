<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@home');
$router->get('/sobre', 'HomeController@sobre');

$router->get('/users', 'UsersController@list');
$router->get('/users/cadastrar', 'UsersController@cadastrar');
$router->post('/users/store', 'UsersController@store');

$router->get('/groups', 'GroupsController@list');
$router->get('/groups/cadastrar', 'GroupsController@cadastrar');
$router->post('/groups/store', 'GroupsController@store');
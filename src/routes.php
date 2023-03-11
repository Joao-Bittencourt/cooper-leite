<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@home');
$router->get('/sobre', 'HomeController@sobre');

$router->get('/auth/user', 'UsersController@login');
$router->post('/auth', 'UsersController@auth');

$router->get('/users', 'UsersController@list');
$router->get('/users/cadastrar', 'UsersController@cadastrar');
$router->post('/users/store', 'UsersController@store');

$router->get('/groups', 'GroupsController@list');
$router->get('/groups/cadastrar', 'GroupsController@cadastrar');
$router->post('/groups/store', 'GroupsController@store');

$router->get('/clientes', 'ClientesController@list');
$router->get('/clientes/show/{id}', 'ClientesController@show');
$router->get('/clientes/edit/{id}', 'ClientesController@edit');
$router->get('/clientes/add', 'ClientesController@add');
$router->post('/clientes/update/{id}', 'ClientesController@update');
$router->post('/clientes/store', 'ClientesController@store');
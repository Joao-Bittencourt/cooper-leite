<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@home');
$router->get('/sobre', 'HomeController@sobre');

//@Todo: criar controller para dasboard
$router->get('/dashboard', 'ClientesController@list');

$router->get('/auth/user', 'UsersController@login');
$router->get('/auth/user/logout', 'UsersController@logout');
$router->post('/auth', 'UsersController@auth');

$router->get('/clientes', 'ClientesController@list');
$router->get('/clientes/show/{id}', 'ClientesController@show');
$router->get('/clientes/edit/{id}', 'ClientesController@edit');
$router->get('/clientes/cadastrar', 'ClientesController@add');
$router->post('/clientes/update/{id}', 'ClientesController@update');
$router->post('/clientes/store', 'ClientesController@store');

$router->get('/grupos', 'GroupsController@list');
$router->get('/grupos/cadastrar', 'GroupsController@cadastrar');
$router->post('/groups/store', 'GroupsController@store');

$router->get('/produtos', 'ProdutosController@list');
$router->get('/produtos/cadastrar', 'ProdutosController@cadastrar');
$router->post('/produtos/store', 'ProdutosController@store');

$router->get('/usuarios', 'UsersController@list');
$router->get('/usuarios/cadastrar', 'UsersController@cadastrar');
$router->post('/users/store', 'UsersController@store');




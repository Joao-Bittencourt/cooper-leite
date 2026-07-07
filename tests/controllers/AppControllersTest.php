<?php

namespace CooperLeite\Tests\controllers;

use CooperLeite\Tests\models\ModelTestCase;
use CooperLeite\controllers\HomeController;
use CooperLeite\controllers\ErrorController;
use CooperLeite\controllers\GroupsController;
use CooperLeite\controllers\UsersController;
use CooperLeite\controllers\ProdutosController;
use CooperLeite\controllers\ClientesController;
use CooperLeite\models\Group;
use CooperLeite\models\User;
use CooperLeite\models\Produto;
use CooperLeite\models\Cliente;

class AppControllersTest extends ModelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $_SESSION = [];
    }

    // -------------------------------------------------------------
    // HomeController Tests
    // -------------------------------------------------------------
    public function test_home_controller()
    {
        $controller = new HomeController();
        $this->assertEquals('home', $controller->layout);
        $controller->home();
        $this->assertTrue(true);
    }

    // -------------------------------------------------------------
    // ErrorController Tests
    // -------------------------------------------------------------
    public function test_error_controller()
    {
        $controller = new ErrorController();
        $this->expectException(\Exception::class);
        $controller->index();
    }

    // -------------------------------------------------------------
    // GroupsController Tests
    // -------------------------------------------------------------
    public function test_groups_controller_list()
    {
        $group = new Group();
        $group->salvar(['name' => 'Admins']);

        $controller = new GroupsController();
        $controller->list();

        $this->assertNotEmpty($controller->data['groups']);
        $this->assertEquals('Admins', $controller->data['groups'][0]->name);
    }

    public function test_groups_controller_cadastrar()
    {
        $controller = new GroupsController();
        $controller->cadastrar();
        $this->assertTrue(true);
    }

    public function test_groups_controller_store_success()
    {
        $controller = new GroupsController();
        $controller->data['Request']['data'] = ['name' => 'Managers'];

        $controller->store([]);

        $dbGroup = Group::where('name', 'Managers')->first();
        $this->assertNotEmpty($dbGroup);
        $this->assertEquals('Grupo cadastrado com sucesso!', $_SESSION['FLASH_MESSAGES'][0]['message']);
    }

    // -------------------------------------------------------------
    // UsersController Tests
    // -------------------------------------------------------------
    public function test_users_controller_list()
    {
        $user = new User();
        $user->salvar(['email' => 'a@b.com', 'login' => 'a', 'password' => '123']);

        $controller = new UsersController();
        $controller->list();

        $this->assertNotEmpty($controller->data['users']);
    }

    public function test_users_controller_cadastrar_login()
    {
        $controller = new UsersController();
        $controller->cadastrar();
        $controller->login();
        $this->assertEquals('login', $controller->layout);
    }

    public function test_users_controller_store_success()
    {
        $controller = new UsersController();
        $controller->data['Request']['data'] = [
            'email' => 'user@example.com',
            'login' => 'testuser',
            'password' => 'secretpass'
        ];

        $controller->store();

        $dbUser = User::where('login', 'testuser')->first();
        $this->assertNotEmpty($dbUser);
    }

    public function test_users_controller_store_error()
    {
        $controller = new UsersController();
        $controller->data['Request']['data'] = [
            'email' => '',
            'login' => '',
            'password' => ''
        ];

        $controller->store();
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_users_controller_logout()
    {
        $controller = new UsersController();
        $controller->logout();
        $this->assertEmpty($_SESSION['Auth'] ?? []);
    }

    public function test_users_controller_auth_success()
    {
        $user = new User();
        // Auth::login queries password = '...' directly from database, so we save it as md5('secret')
        // since $data['password'] in the controller will be compared against the DB value.
        $user->salvar([
            'email' => 'u@e.com',
            'login' => 'userlogin',
            'password' => 'secret',
            'status' => 1
        ]);

        $controller = new UsersController();
        $controller->data['Request']['data'] = [
            'login' => 'userlogin',
            'password' => 'secret'
        ];

        $controller->auth();
        $this->assertNotEmpty($_SESSION['Auth']['jwt']);
    }

    public function test_users_controller_auth_failure()
    {
        $controller = new UsersController();
        $controller->data['Request']['data'] = [
            'login' => 'nonexistent',
            'password' => 'wrong'
        ];

        $controller->auth();
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    // -------------------------------------------------------------
    // ProdutosController Tests
    // -------------------------------------------------------------
    public function test_produtos_controller_list_add()
    {
        $controller = new ProdutosController();
        $controller->list();
        $controller->add();
        $this->assertTrue(true);
    }

    public function test_produtos_controller_store_success()
    {
        $controller = new ProdutosController();
        $controller->data['Request']['data'] = [
            'nome' => 'Leite Especial',
            'unidade' => 'L'
        ];

        $controller->store();

        $dbProduct = Produto::where('nome', 'Leite Especial')->first();
        $this->assertNotEmpty($dbProduct);
    }

    public function test_produtos_controller_store_error()
    {
        $controller = new ProdutosController();
        $controller->data['Request']['data'] = [
            'nome' => '',
            'unidade' => ''
        ];

        $controller->store();
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_produtos_controller_show_success()
    {
        $produto = new Produto();
        $produto->salvar(['nome' => 'L', 'unidade' => 'U']);

        $controller = new ProdutosController();
        $controller->show(['id' => $produto->id]);

        $this->assertEquals($produto->id, $controller->data['produto']->id);
    }

    public function test_produtos_controller_show_not_found()
    {
        $controller = new ProdutosController();
        $controller->show(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_produtos_controller_edit_success()
    {
        $produto = new Produto();
        $produto->salvar(['nome' => 'L', 'unidade' => 'U']);

        $controller = new ProdutosController();
        $controller->edit(['id' => $produto->id]);

        $this->assertEquals($produto->id, $controller->data['produto']->id);
    }

    public function test_produtos_controller_edit_not_found()
    {
        $controller = new ProdutosController();
        $controller->edit(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_produtos_controller_update_success()
    {
        $produto = new Produto();
        $produto->salvar(['nome' => 'L', 'unidade' => 'U']);

        $controller = new ProdutosController();
        $controller->data = [
            'nome' => 'L2',
            'unidade' => 'U2'
        ];

        $controller->update(['id' => $produto->id]);

        $dbRecord = Produto::find($produto->id);
        $this->assertEquals('L2', $dbRecord->nome);
    }

    public function test_produtos_controller_update_not_found()
    {
        $controller = new ProdutosController();
        $controller->update(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_produtos_controller_update_validation_error()
    {
        $produto = new Produto();
        $produto->salvar(['nome' => 'L', 'unidade' => 'U']);

        $controller = new ProdutosController();
        $controller->data = [
            'nome' => '',
            'unidade' => 'U2'
        ];

        $controller->update(['id' => $produto->id]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    // -------------------------------------------------------------
    // ClientesController Tests
    // -------------------------------------------------------------
    public function test_clientes_controller_list_add()
    {
        $controller = new ClientesController();
        $controller->list();
        $controller->add();
        $this->assertTrue(true);
    }

    public function test_clientes_controller_store_success()
    {
        $controller = new ClientesController();
        $controller->data['Request']['data'] = [
            'nome' => 'Cliente Teste',
            'tipo_pessoa' => 'F',
            'papel' => 'C',
            'PessoaFisica-nome_civil' => 'Civil',
            'PessoaFisica-dt_nascimento' => '10/10/1990'
        ];

        $controller->store([]);

        $dbRecord = Cliente::where('nome', 'Cliente Teste')->first();
        $this->assertNotEmpty($dbRecord);
    }

    public function test_clientes_controller_store_error()
    {
        $controller = new ClientesController();
        $controller->data['Request']['data'] = [
            'nome' => '',
            'tipo_pessoa' => '',
            'papel' => ''
        ];

        $controller->store([]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_clientes_controller_show_success()
    {
        $cliente = new Cliente();
        $cliente->salvar(['nome' => 'C', 'tipo_pessoa' => 'F', 'papel' => 'C']);

        $controller = new ClientesController();
        $controller->show(['id' => $cliente->id]);

        $this->assertEquals($cliente->id, $controller->data['Cliente']->id);
    }

    public function test_clientes_controller_show_not_found()
    {
        $controller = new ClientesController();
        $controller->show(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_clientes_controller_edit_success()
    {
        $cliente = new Cliente();
        $cliente->salvar(['nome' => 'C', 'tipo_pessoa' => 'F', 'papel' => 'C']);

        $controller = new ClientesController();
        $controller->edit(['id' => $cliente->id]);

        $this->assertEquals($cliente->id, $controller->data['Cliente']->id);
    }

    public function test_clientes_controller_edit_not_found()
    {
        $controller = new ClientesController();
        $controller->edit(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_clientes_controller_update_success()
    {
        $cliente = new Cliente();
        $cliente->salvar(['nome' => 'C', 'tipo_pessoa' => 'F', 'papel' => 'C']);

        $controller = new ClientesController();
        $controller->data = [
            'Request' => [
                'data' => [
                    'PessoaFisica-id' => $cliente->pessoaFisica->id,
                    'PessoaFisica-nome_civil' => 'Updated Civil'
                ]
            ]
        ];

        $controller->update(['id' => $cliente->id]);

        $dbRecord = Cliente::find($cliente->id);
        $this->assertEquals('Updated Civil', $dbRecord->pessoaFisica->nome_civil);
    }

    public function test_clientes_controller_update_not_found()
    {
        $controller = new ClientesController();
        $controller->update(['id' => 999]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }

    public function test_clientes_controller_update_error()
    {
        $cliente = new Cliente();
        $cliente->salvar(['nome' => 'C', 'tipo_pessoa' => 'F', 'papel' => 'C']);

        $controller = new ClientesController();
        $controller->data = [
            'Request' => [
                'data' => [
                    'nome' => '',
                    'tipo_pessoa' => 'F',
                    'papel' => 'C'
                ]
            ]
        ];

        $controller->update(['id' => $cliente->id]);
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES']);
    }
}

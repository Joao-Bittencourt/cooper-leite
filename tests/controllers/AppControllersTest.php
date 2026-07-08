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
        // Set a valid authenticated JWT so controller constructors do not trigger auth redirects
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';
        $GLOBALS['mock_headers_sent'] = false;
        $GLOBALS['mock_headers'] = [];
        unset($GLOBALS['mock_response_code']);
        http_response_code_wrapper(200);
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
        $this->assertHasFlashMessage('Grupo cadastrado com sucesso!', 'success');
        $this->assertRedirectsTo('/grupos');
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
        $this->assertHasFlashMessage('Usuario cadastrado com sucesso!', 'success');
        $this->assertRedirectsTo('/usuarios');
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
        $this->assertHasFlashMessage('preenchido', 'danger');
        $this->assertRedirectsTo('/usuarios/cadastrar');
    }

    public function test_users_controller_logout()
    {
        $_SESSION['Auth']['jwt'] = 'dummy';
        $controller = new UsersController();
        $controller->logout();
        $this->assertEmpty($_SESSION['Auth'] ?? []);
        $this->assertRedirectsTo('/auth/user');
    }

    public function test_users_controller_auth_success()
    {
        $user = new User();
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
        $this->assertRedirectsTo('/dashboard');
    }

    public function test_users_controller_auth_failure()
    {
        $controller = new UsersController();
        $controller->data['Request']['data'] = [
            'login' => 'nonexistent',
            'password' => 'wrong'
        ];

        $controller->auth();
        $this->assertHasFlashMessage('Email ou senha inválidos', 'danger');
        $this->assertRedirectsTo('/auth/user');
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
        $this->assertHasFlashMessage('Produto cadastrado com sucesso!', 'success');
        $this->assertRedirectsTo('/produtos');
    }

    public function test_produtos_controller_store_error()
    {
        $controller = new ProdutosController();
        $controller->data['Request']['data'] = [
            'nome' => '',
            'unidade' => ''
        ];

        $controller->store();
        $this->assertHasFlashMessage('preenchido', 'danger');
        $this->assertRedirectsTo('/produtos/cadastrar');
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
        $this->assertHasFlashMessage('Produto #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');
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
        $this->assertHasFlashMessage('Produto #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');
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
        $this->assertHasFlashMessage('Produto editado com sucesso!', 'success');
        $this->assertRedirectsTo('/produtos');
    }

    public function test_produtos_controller_update_not_found()
    {
        $controller = new ProdutosController();
        $controller->update(['id' => 999]);
        $this->assertHasFlashMessage('Produto #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');
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
        $this->assertHasFlashMessage('Nome deve ser preenchido.', 'danger');
        $this->assertRedirectsTo('/produtos/edit/' . $produto->id);
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
        $this->assertHasFlashMessage('Cliente cadastrado com sucesso!', 'success');
        $this->assertRedirectsTo('/clientes');
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
        $this->assertHasFlashMessage('preenchido', 'danger');
        $this->assertRedirectsTo('/clientes/cadastrar');
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
        $this->assertHasFlashMessage('Cliente #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');
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
        $this->assertHasFlashMessage('Cliente #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');
    }

    public function test_clientes_controller_update_success()
    {
        $cliente = new Cliente();
        $cliente->salvar(['nome' => 'C', 'tipo_pessoa' => 'F', 'papel' => 'C']);

        $controller = new ClientesController();
        $controller->data = [
            'Request' => [
                'data' => [
                    'nome' => 'New Name',
                    'tipo_pessoa' => 'F',
                    'papel' => 'C',
                    'PessoaFisica-id' => $cliente->pessoaFisica->id,
                    'PessoaFisica-nome_civil' => 'Updated Civil'
                ]
            ]
        ];

        $controller->update(['id' => $cliente->id]);

        $dbRecord = Cliente::find($cliente->id);
        $this->assertEquals('Updated Civil', $dbRecord->pessoaFisica->nome_civil);
        $this->assertEquals('New Name', $dbRecord->nome);
        $this->assertHasFlashMessage('Cliente editado com sucesso!', 'success');
        $this->assertRedirectsTo('/clientes');
    }

    public function test_clientes_controller_update_not_found()
    {
        $controller = new ClientesController();
        $controller->update(['id' => 999]);
        $this->assertHasFlashMessage('Cliente #999 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');
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
        $this->assertHasFlashMessage('Nome deve ser preenchido.', 'danger');
        $this->assertRedirectsTo('/clientes/cadastrar');
    }

    public function test_clientes_controller_edge_cases()
    {
        // show no id
        $controller = new ClientesController();
        $controller->show([]);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');

        // show non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->show(['id' => 'abc']);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');

        // edit no id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->edit([]);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');

        // edit non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->edit(['id' => 'abc']);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');

        // update no id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->update([]);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');

        // update non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->update(['id' => 'abc']);
        $this->assertHasFlashMessage('Cliente #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/clientes');
    }

    public function test_produtos_controller_edge_cases()
    {
        // show no id
        $controller = new ProdutosController();
        $controller->show([]);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');

        // show non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->show(['id' => 'abc']);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');

        // edit no id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->edit([]);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');

        // edit non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->edit(['id' => 'abc']);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');

        // update no id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->update([]);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');

        // update non numeric id
        $_SESSION = [];
        $GLOBALS['mock_headers'] = [];
        $controller->update(['id' => 'abc']);
        $this->assertHasFlashMessage('Produto #0 não encontrado!', 'info');
        $this->assertRedirectsTo('/produtos');
    }

    private function assertRedirectsTo($url)
    {
        $this->assertEquals(302, http_response_code_wrapper());
        $found = false;
        $unexpectedRedirect = null;
        if (isset($GLOBALS['mock_headers'])) {
            foreach ($GLOBALS['mock_headers'] as $headerInfo) {
                if (strpos($headerInfo[0], 'Location:') === 0) {
                    $redirectUrl = trim(substr($headerInfo[0], 9));
                    if ($redirectUrl === base_url($url)) {
                        $found = true;
                    } else {
                        if (($redirectUrl === base_url('/dashboard') && $url !== '/dashboard') ||
                            ($redirectUrl === base_url('/auth/user') && $url !== '/auth/user')) {
                            $unexpectedRedirect = $redirectUrl;
                        }
                    }
                }
            }
        }
        $this->assertNull($unexpectedRedirect, "Unexpected authorization/authentication redirect to: " . $unexpectedRedirect);
        $this->assertTrue($found, "Failed asserting redirection to: " . $url . " (actual headers: " . json_encode($GLOBALS['mock_headers'] ?? []) . ")");
    }

    private function assertHasFlashMessage($containsMessage, $type = null)
    {
        $this->assertNotEmpty($_SESSION['FLASH_MESSAGES'] ?? [], "No flash messages set in session");
        $found = false;
        foreach ($_SESSION['FLASH_MESSAGES'] as $msg) {
            if (strpos($msg['message'], $containsMessage) !== false) {
                if ($type === null || $msg['type'] === $type) {
                    $found = true;
                    break;
                }
            }
        }
        $this->assertTrue($found, "Flash message containing '{$containsMessage}' (type: " . ($type ?? 'any') . ") not found.");
    }
}

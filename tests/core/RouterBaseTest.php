<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\RouterBase;
use core\CoreException;

class RouterBaseTest extends TestCase
{
    private $routerBase;

    public function setUp(): void
    {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
        $this->routerBase = new RouterBase();
    }

    public function test_run_method_inexistente()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $routes = [
            'GET_INEXISTENTE' => [
                '/'
            ]
        ];

        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
    }

    public function test_run_route_inexistente()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/rota_inexistente';
        $routes['GET'] = ['/outra_rota' => 'HomeController@home'];

        try {
            $this->routerBase->run($routes);
            $this->fail("CoreException not thrown");
        } catch (CoreException $e) {
            $this->assertEquals(404, http_response_code_wrapper());
            $this->assertEquals("/rota_inexistente not found.", $e->getMessage());
        }
    }
    public function test_run_controller_inexistente()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => 'InexistenteController@home'];

        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
    }

    public function test_run_controller_action_inexistente()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => 'HomeController@Inexistente'];

        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
    }

    public function test_run_controller_empty()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => '@Inexistente'];

        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
    }

    public function test_run_controller_action_inexistente_with_args()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/Home/inexistente/1';

        $routes['GET'] = ['/Home/inexistente/{id}' => 'HomeController@Inexistente'];
        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
    }

    public function test_run_success()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fake/home';

        $routes['GET'] = ['/fake/home' => 'FakeHomeController@home'];

        ob_start();
        $this->routerBase->run($routes);
        $output = ob_get_clean();

        $this->assertEquals("Controller: FakeHome - Action: home", $output);
    }

    public function test_run_success_with_args()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fake/home/123/my-slug';

        $routes['GET'] = ['/fake/home/{id}/{slug}' => 'FakeHomeController@homeWithArgs'];

        ob_start();
        $this->routerBase->run($routes);
        $output = ob_get_clean();

        $this->assertEquals("Args: 123 - my-slug", $output);
    }

    public function test_run_first_route_precedence()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fake/first';

        $routes['GET'] = [
            '/fake/first' => 'FakeHomeController@first',
            '/fake/{slug}' => 'FakeHomeController@second',
        ];

        ob_start();
        $this->routerBase->run($routes);
        $output = ob_get_clean();

        $this->assertEquals("First Route Called", $output);
    }

    public function test_run_default_action_fallback()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/fake/default';

        $routes['GET'] = ['/fake/default' => 'FakeHomeController'];

        ob_start();
        $this->routerBase->run($routes);
        $output = ob_get_clean();

        $this->assertEquals("Controller: FakeHome - Action: index", $output);
    }
}

namespace CooperLeite\controllers;

class FakeHomeController
{
    public $data = [];
    public $controller;
    public $action;
    public function _checkAuth()
    {
        return true;
    }
    public function home($args)
    {
    }
    public function homeWithArgs($args)
    {
    }
    public function first($args)
    {
    }
    public function second($args)
    {
    }
    public function index($args)
    {
    }
    public function layout($action, $args)
    {
        if ($action === 'homeWithArgs') {
            return "Args: " . $args['id'] . " - " . $args['slug'];
        }
        if ($action === 'first') {
            return "First Route Called";
        }
        if ($action === 'second') {
            return "Second Route Called";
        }
        return "Controller: " . $this->controller . " - Action: " . $this->action;
    }
}

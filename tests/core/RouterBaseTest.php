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
        $routes['GET'] = ['/rota_inexistente' => 'HomeController@home'];

        $this->expectException(CoreException::class);
        $this->routerBase->run($routes);
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

        $this->assertEquals("Fake Layout Content", $output);
    }
}

namespace CooperLeite\controllers;

class FakeHomeController
{
    public $data = [];
    public $controller;
    public $action;
    public function _checkAuth() { return true; }
    public function home($args) {}
    public function layout($action, $args) { return "Fake Layout Content"; }
}

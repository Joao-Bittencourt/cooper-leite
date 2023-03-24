<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\RouterBase;

class RouterBaseTest extends TestCase {

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
        $this->RouterBase = new RouterBase();
    }

    public function test_run_method_inexistente() {

        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $routes = [
            'GET_INEXISTENTE' => [
                '/'
            ]
        ];

        $this->expectException(\Exception::class);
        $this->RouterBase->run($routes);
    }

    public function test_run_route_inexistente() {

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/rota_inexistente' => 'HomeController@home'];

        $this->expectException(\Exception::class);
        $this->RouterBase->run($routes);
//        $this->expectException(\Exception::class);;
    }
    public function test_run_controller_inexistente() {

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => 'InexistenteController@home'];

        $this->expectException(\Exception::class);
        $this->RouterBase->run($routes);
    }
    
    public function test_run_controller_action_inexistente() {

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => 'HomeController@Inexistente'];

        $this->expectException(\Exception::class);
        $this->RouterBase->run($routes);
    }
    public function test_run_controller_empty() {

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $routes['GET'] = ['/' => '@Inexistente'];

        $this->expectException(\Exception::class);
        $this->RouterBase->run($routes);
    }

}

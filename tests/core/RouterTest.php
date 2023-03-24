<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Router;

class RouterTest extends TestCase {

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
        $this->Router = new Router();
    }
    
    /**
     * @dataProvider routerProvider
     */
    public function test_router_get($endpoint, $trigger) {
        
        $this->Router->get($endpoint, $trigger);
        
        $expectedResult['GET'][$endpoint] = $trigger;
                
        $this->assertEquals($expectedResult, $this->Router->routes);
    }
    
    /**
     * @dataProvider routerProvider
     */
    public function test_router_post($endpoint, $trigger) {
        
        $this->Router->post($endpoint, $trigger);
        
        $expectedResult['POST'][$endpoint] = $trigger;
                
        $this->assertEquals($expectedResult, $this->Router->routes);
    }

    /**
     * @dataProvider routerProvider
     */
    public function test_router_put($endpoint, $trigger) {
        
        $this->Router->put($endpoint, $trigger);
        
        $expectedResult['PUT'][$endpoint] = $trigger;
                
        $this->assertEquals($expectedResult, $this->Router->routes);
    }
    
    /**
     * @dataProvider routerProvider
     */
    public function test_router_delete($endpoint, $trigger) {
        
        $this->Router->delete($endpoint, $trigger);
        
        $expectedResult['DELETE'][$endpoint] = $trigger;
                
        $this->assertEquals($expectedResult, $this->Router->routes);
    }
    
    // Providers

    public function routerProvider() {
        return [
            ['/', 'controller@action'],
            ['/2', 'controller2@action'],
            ['/listar', 'controller@listar'],
            ['/detalhar/{id}', 'controller@detalhar']
        ];
    }
}

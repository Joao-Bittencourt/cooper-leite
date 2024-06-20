<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Router;

class RouterTest extends TestCase
{
    private $router;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    /**
     * @dataProvider routerProvider
     */
    public function test_router_get($endpoint, $trigger)
    {
        $this->router->get($endpoint, $trigger);

        $expectedResult['GET'][$endpoint] = $trigger;

        $this->assertEquals($expectedResult, $this->router->routes);
    }

    /**
     * @dataProvider routerProvider
     */
    public function test_router_post($endpoint, $trigger)
    {
        $this->router->post($endpoint, $trigger);

        $expectedResult['POST'][$endpoint] = $trigger;

        $this->assertEquals($expectedResult, $this->router->routes);
    }

    /**
     * @dataProvider routerProvider
     */
    public function test_router_put($endpoint, $trigger)
    {
        $this->router->put($endpoint, $trigger);

        $expectedResult['PUT'][$endpoint] = $trigger;

        $this->assertEquals($expectedResult, $this->router->routes);
    }

    /**
     * @dataProvider routerProvider
     */
    public function test_router_delete($endpoint, $trigger)
    {
        $this->router->delete($endpoint, $trigger);

        $expectedResult['DELETE'][$endpoint] = $trigger;

        $this->assertEquals($expectedResult, $this->router->routes);
    }

    // Providers

    public function routerProvider()
    {
        return [
            ['/', 'controller@action'],
            ['/2', 'controller2@action'],
            ['/listar', 'controller@listar'],
            ['/detalhar/{id}', 'controller@detalhar']
        ];
    }
}

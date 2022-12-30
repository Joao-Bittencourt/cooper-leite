<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Controller;

class ControllerTest extends TestCase {
    public $controller;
    
    public function setUp(): void {
        $this->controller = new Controller();
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
    }

    public function test_render_null() {
        $this->expectException(\Exception::class);
        $this->controller->render(null);
    }
    
//    public function test_render_404() {
//        $this->assertStringContainsString('Página não encontrada', $this->controller->render('404'));
//        
//    }

}

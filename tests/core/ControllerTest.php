<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\Controller;

class ControllerTest extends TestCase {

    public $controller;

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
        $this->Controller = new Controller();
        include_once './src/core/basics.php';
    }

    public function test_render_null() {
        $this->expectException(\Exception::class);
        $this->Controller->render(null);
    }

    public function test_render_404() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Page /404 not found.', $this->Controller->render('404'));
    }

    public function test_render_layout_null() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Page / not found.', $this->Controller->renderLayout(null, []));
    }

    public function test_render_layout_default() {

        $result = $this->Controller->renderLayout('exception', ['code' => '400', 'message' => 'teste']);

        $this->assertStringContainsString("<nav class='main-header navbar navbar-expand navbar-white navbar-light'>", $result);
        $this->assertStringContainsString('teste', $result);
    }

    public function test_render_layout_exception() {
        $this->Controller->layout = 'exception';
        $result = $this->Controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $this->assertStringContainsString('<body id="exception">', $result);
        $this->assertStringContainsString('exception', $result);
    }

    public function test_render_layout() {

        $result = $this->Controller->layout('exception', ['code' => '400', 'message' => 'teste']);

        $this->assertStringContainsString("<nav class='main-header navbar navbar-expand navbar-white navbar-light'>", $result);
        $this->assertStringContainsString('teste', $result);
    }

    public function test_check_auth_not_authenticated() {

        $this->Controller->controller = 'controller';
        $this->Controller->action = 'action';
        $this->assertFalse($this->Controller->_checkAuth());
    }

    public function test_check_auth_not_authenticated_authorized() {

        $this->Controller->controller = 'Users';
        $this->Controller->action = 'login';
        
        $this->assertFalse($this->Controller->_checkAuth());
        $this->assertStringContainsString('Usuario não autenticado!', $_SESSION['FLASH_MESSAGES'][0]['message']);
        $this->assertEquals(302, http_response_code());
    }

}

<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Controller;

class ControllerTest extends TestCase {

    public $controller;

    public function setUp(): void {
        include_once './src/core/basics.php';
        $this->Controller = new Controller();
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

    public function test_render_layout_exception_400() {
        $this->Controller->layout = 'exception';
        $result = $this->Controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $this->assertStringContainsString('<body id="exception">', $result);
        $this->assertStringContainsString('exception', $result);
        $this->assertStringContainsString('<div class="alert alert-info mt-5">', $result);
    }
    
    public function test_render_layout_exception_500() {
        $this->Controller->layout = 'exception';
        $result = $this->Controller->renderLayout('exception', ['code' => '500', 'message' => 'Erro inexperado.']);

        $this->assertStringContainsString('<body id="exception">', $result);
        $this->assertStringContainsString('Erro inexperado.', $result);
        $this->assertStringContainsString('<div class="alert alert-danger mt-5">', $result);
    }
    
    public function test_render_layout_login() {
        $this->Controller->layout = 'login';
        $result = $this->Controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $this->assertStringContainsString('<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <title> CooperLeite </title>
    </head>', $result);
        $this->assertStringContainsString('exception', $result);
    }
    
    public function test_render_layout_home() {
        $this->Controller->layout = 'home';
        $result = $this->Controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $this->assertStringContainsString('<footer class="pt-5 my-5 text-muted  text-center">
    COOPERLEITE&middot; &copy; 2022
</footer>', $result);
        $this->assertStringContainsString('exception', $result);
    }

    public function test_render_layout() {

        $result = $this->Controller->layout('exception', ['code' => '400', 'message' => 'teste']);

//        $this->assertStringContainsString("<nav class='main-header navbar navbar-expand navbar-white navbar-light'>", $result);
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

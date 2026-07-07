<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\Controller;

class ControllerTest extends TestCase
{
    public $controller;

    public function setUp(): void
    {
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '80';
        include_once './src/core/basics.php';
        $this->controller = new Controller();
        $_SESSION = [];
        $GLOBALS['mock_headers_sent'] = false;
        unset($GLOBALS['mock_response_code']);
        http_response_code_wrapper(200);
    }

    public function test_render_null()
    {
        $this->expectException(\Exception::class);
        $this->controller->render(null);
    }

    public function test_render_404()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Page /404 not found.', $this->controller->render('404'));
    }

    public function test_render_layout_null()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Page / not found.', $this->controller->renderLayout(null, []));
    }

    public function test_render_layout_default()
    {
        $result = $this->controller->renderLayout('exception', ['code' => '400', 'message' => 'teste']);

        $this->assertStringContainsString("<nav class='main-header navbar navbar-expand navbar-white navbar-light'>", $result);
        $this->assertStringContainsString('teste', $result);
    }

    public function test_render_layout_exception_400()
    {
        $this->controller->layout = 'exception';
        $result = $this->controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $this->assertStringContainsString('<body id="exception">', $result);
        $this->assertStringContainsString('exception', $result);
        $this->assertStringContainsString('<div class="alert alert-info mt-5">', $result);
    }

    public function test_render_layout_exception_500()
    {
        $this->controller->layout = 'exception';
        $result = $this->controller->renderLayout('exception', ['code' => '500', 'message' => 'Erro inexperado.']);

        $this->assertStringContainsString('<body id="exception">', $result);
        $this->assertStringContainsString('Erro inexperado.', $result);
        $this->assertStringContainsString('<div class="alert alert-danger mt-5">', $result);
    }

    public function test_render_layout_login()
    {
        $this->controller->layout = 'login';
        $result = $this->controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $expected = '<head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
            <title> CooperLeite </title>
        </head>';

        $this->assertStringContainsString(
            trim(preg_replace('/\s+/', '', $expected)),
            trim(preg_replace('/\s+/', '', $result))
        );
        $this->assertStringContainsString('exception', $result);
    }

    public function test_render_layout_home()
    {
        $this->controller->layout = 'home';
        $result = $this->controller->renderLayout('exception', ['code' => '400', 'message' => 'exception']);

        $expected = '<footer class="pt-5 my-5 text-muted  text-center">
            COOPERLEITE&middot; &copy; 2022
        </footer>';

        $this->assertStringContainsString(
            trim(preg_replace('/\s+/', '', $expected)),
            trim(preg_replace('/\s+/', '', $result))
        );
        $this->assertStringContainsString('exception', $result);
    }

    public function test_render_layout()
    {
        $result = $this->controller->layout('exception', ['code' => '400', 'message' => 'teste']);

//        $this->assertStringContainsString("<nav class='main-header navbar navbar-expand navbar-white navbar-light'>", $result);
        $this->assertStringContainsString('teste', $result);
    }

    public function test_check_auth_not_authenticated()
    {
        $this->controller->controller = 'controller';
        $this->controller->action = 'action';
        $this->assertFalse($this->controller->_checkAuth());
        $this->assertStringContainsString('Usuario não autenticado!', $_SESSION['FLASH_MESSAGES'][0]['message']);
        $this->assertEquals(302, http_response_code_wrapper());
    }

    public function test_check_auth_not_authenticated_authorized()
    {
        $this->controller->controller = 'Users';
        $this->controller->action = 'login';

        $this->assertFalse($this->controller->_checkAuth());
        $this->assertEmpty($_SESSION['FLASH_MESSAGES'] ?? []);
        $this->assertNotEquals(302, http_response_code_wrapper());
    }

    public function test_check_auth_authenticated_but_unauthorized()
    {
        $_SESSION['Auth']['jwt'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTgsImVtYWlsIjoiam9hb2dzYml0dGVuY291cnRAZ21haWwuY29tIiwiZ3JvdXBfaWQiOjB9.NljCZ85MBvTw87p92EmGG7UFLW1VLRHY2yobYmaOTS8';
        $_SESSION['Auth']['role'] = 'unauthorized';

        $this->controller->controller = 'SomeRestrictedController';
        $this->controller->action = 'index';

        $this->assertTrue($this->controller->_checkAuth());
        $this->assertStringContainsString('Usuario sem permissao!', $_SESSION['FLASH_MESSAGES'][0]['message']);
        $this->assertEquals(302, http_response_code_wrapper());
    }

    public function test_render_partial()
    {
        $method = new \ReflectionMethod(Controller::class, 'renderPartial');
        $method->setAccessible(true);

        $this->expectException(\Exception::class);
        $method->invoke($this->controller, 'inexistente');
    }

    public function test_render_partial_success()
    {
        $method = new \ReflectionMethod(Controller::class, 'renderPartial');
        $method->setAccessible(true);

        $result = $method->invoke($this->controller, 'someView', []);
        $this->assertEmpty($result);
    }

    public function test_folder_name_with_argument()
    {
        $method = new \ReflectionMethod(Controller::class, 'folderName');
        $method->setAccessible(true);

        $result = $method->invoke($this->controller, 'custom_folder');
        $this->assertEquals('custom_folder', $result);
    }

    public function test_folder_name_with_existing_folder()
    {
        $controller = new ClientesController();
        $method = new \ReflectionMethod(Controller::class, 'folderName');
        $method->setAccessible(true);

        $result = $method->invoke($controller);
        $this->assertEquals('Clientes', $result);
    }

    public function test_redirect_headers_sent()
    {
        $GLOBALS['mock_headers_sent'] = true;

        $method = new \ReflectionMethod(Controller::class, 'redirect');
        $method->setAccessible(true);
        
        $method->invoke($this->controller, '/dashboard');
        
        $this->assertTrue(\core\headers_sent());
    }

    protected function tearDown(): void
    {
        $GLOBALS['mock_headers_sent'] = false;
        unset($GLOBALS['mock_response_code']);
    }
}

class ClientesController extends Controller {}

<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use core\CoreException;

class CoreExceptionTest extends TestCase {

    public $controller;

    public function setUp(): void {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';
        include_once './src/core/basics.php';
    }

    public function test_core_exception() {

        $message = 'mensagem';
        $code = 500;
        $result = new CoreException($message, $code);

        $this->assertTrue($result instanceof \exception);
        $this->assertEquals(500, http_response_code());
    }

}

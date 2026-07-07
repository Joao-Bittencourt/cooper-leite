<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use core\CoreException;

class CoreExceptionTest extends TestCase
{
    public $controller;

    public function setUp(): void
    {
        include_once './src/core/basics.php';
        $GLOBALS['mock_headers_sent'] = false;
        unset($GLOBALS['mock_response_code']);
    }

    protected function tearDown(): void
    {
        $GLOBALS['mock_headers_sent'] = false;
        unset($GLOBALS['mock_response_code']);
    }

    public function test_core_exception()
    {
        $message = 'mensagem';
        $code = 500;
        $result = new CoreException($message, $code);

        $this->assertTrue($result instanceof \exception);
        $this->assertEquals(500, http_response_code_wrapper());
    }

    public function test_core_exception_headers_sent()
    {
        $GLOBALS['mock_headers_sent'] = true;

        $message = 'mensagem';
        $code = 500;
        $result = new CoreException($message, $code);

        $this->assertTrue($result instanceof \exception);
    }
}

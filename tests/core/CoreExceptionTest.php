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

    public function test_core_exception_default_code()
    {
        unset($_SESSION['FLASH_MESSAGES']);
        $message = 'mensagem_padrao';
        $result = new CoreException($message);

        $this->assertTrue($result instanceof \exception);
        $this->assertEquals(500, http_response_code_wrapper());
    }

    public function test_core_exception_logs_message()
    {
        $logDir = dirname(__DIR__, 2) . '/src/tmp/log';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        $logFile = $logDir . '/log-' . date('Y-m-d') . '.txt';
        if (file_exists($logFile)) {
            @unlink($logFile);
        }

        $message = 'TestUniqueLogMessage_12345';
        $code = 404;
        new CoreException($message, $code);

        $this->assertTrue(file_exists($logFile), "Log file should be created");
        $logContent = file_get_contents($logFile);
        $this->assertStringContainsString($message, $logContent);
        $this->assertStringContainsString("code: " . $code, $logContent);
        $this->assertStringContainsString("url:", $logContent);

        @unlink($logFile);
    }
}

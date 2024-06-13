<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;

class BasicsTest extends TestCase
{
    public function setUp(): void
    {
        $_SERVER['SERVER_NAME'] = 'cli';
        $_SERVER['SERVER_PORT'] = '0';

        include_once './src/core/basics.php';
    }

    /**
     * @dataProvider baseUrlNotInLocalhostProvider
     */
    public function test_base_url_not_in_localhost($url, $expectedUrl)
    {
        $result = base_url($url);

        $this->assertEquals($expectedUrl, $result);
    }

    /**
     * @dataProvider baseUrlInLocalhostProvider
     */
    public function test_base_url_server_name_localhost($url, $expectedUrl)
    {
        $_SERVER['SERVER_NAME'] = 'localhost';
        $result = base_url($url);

        $this->assertEquals($expectedUrl, $result);
    }

    /**
     * @dataProvider baseUrlInLocalhostProvider
     */
    public function test_base_url_http_host_localhost($url, $expectedUrl)
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $result = base_url($url);

        $this->assertEquals($expectedUrl, $result);
    }

    public function test_debug()
    {
        ob_start();
        debug(['a' => 'b']);
        $result = ob_get_clean();
        $expected = <<<EXPECTED

Array
(
    [a] => b
)


EXPECTED;
        $this->assertEquals($expected, $result);
    }

    public function test_write_log()
    {
        $message = 'mensagem de teste :' . random_int(0, 99);
        write_log($message);

        $filepath = dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'log-' . date('Y-m-d') . '.txt';
        $result = file_get_contents($filepath);

        $this->assertStringContainsString($message, $result);
    }

    /**
     * @dataProvider arrayGetProvider
     */
    public function test_array_get($data, $path, $expected, $defaultResult)
    {
        $result = is_null($defaultResult) ? array_get($data, $path) : array_get($data, $path, $defaultResult);

        $this->assertEquals($expected, $result);
    }

    public function test_process_error_message()
    {
        $errors = [
            'campo' => [
                'error no campo'
            ]
        ];

        process_error_message($errors);

        $expected = [
            'message' => ' - error no campo<br>',
            'type' => 'danger'
        ];

        $this->assertEquals($expected, $_SESSION['FLASH_MESSAGES'][0]);
        unset($_SESSION['FLASH_MESSAGES']);
    }

    public function test_process_error_message_multiple()
    {
        $errors = [
            'campo' => [
                'error no campo'
            ],
            'campo2' => [
                'error no campo2',
                'error2 no campo2',
            ]
        ];

        process_error_message($errors);

        $expected = [
            'message' => ' - error no campo<br> - error no campo2<br> - error2 no campo2<br>',
            'type' => 'danger'
        ];

        $this->assertEquals($expected, $_SESSION['FLASH_MESSAGES'][0]);
        unset($_SESSION['FLASH_MESSAGES']);
    }

    /**
     * @dataProvider createFlashMessageProvider
     */
    public function test_create_flash_message($message, $type, $expectedResult)
    {
        create_flash_message($message, $type);
        $this->assertEquals($expectedResult, $_SESSION['FLASH_MESSAGES'][0]);
        unset($_SESSION['FLASH_MESSAGES']);
    }

    /**
     * @dataProvider formatFlashMessageProvider
     */
    public function test_format_flash_message($arrMessage, $expectedResult)
    {
        $result = format_flash_message($arrMessage);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_display_flash_message()
    {
        create_flash_message('display_flash_message', 'danger');
        ob_start();
        display_flash_message();
        $result = ob_get_clean();

        $this->assertEquals("<div class='alert alert-danger'>display_flash_message</div>", $result);
        unset($_SESSION['FLASH_MESSAGES']);
    }

    public function test_display_flash_message_empty()
    {
        ob_start();
        display_flash_message();
        $result = ob_get_clean();

        $this->assertEmpty($result);
    }

    // Providers

    public function baseUrlInLocalhostProvider()
    {
        return [
            ['/', 'vendor/bin/'],
            ['/sobre', 'vendor/bin/sobre'],
            ['/dashboard', 'vendor/bin/dashboard'],
            ['/auth/user', 'vendor/bin/auth/user'],
            ['/auth', 'vendor/bin/auth'],
            ['/clientes', 'vendor/bin/clientes']
        ];
    }

    public function baseUrlNotInLocalhostProvider()
    {
        return [
            ['/', '/'],
            ['/sobre', '/sobre'],
            ['/dashboard', '/dashboard'],
            ['/auth/user', '/auth/user'],
            ['/auth', '/auth'],
            ['/clientes', '/clientes']
        ];
    }

    public function arrayGetProvider()
    {
        return [
            [
                ['data' => 'valor'],
                'data',
                'valor',
                null,
            ],
            [
                ['data' => 'valor2'],
                'data',
                'valor2',
                null,
            ],
            [
                ['data' => ['chave' => 'valor']],
                'data.chave',
                'valor',
                null,
            ],
            [
                ['data' => ['chaveInexistente' => 'valor']],
                'data.chave',
                null,
                null,
            ],
            [
                ['data' => ['chaveInexistente' => 'valor']],
                'data.chave',
                'valorPadrao',
                'valorPadrao',
            ],
            [
                [true => 'valor'],
                true,
                'valor',
                null,
            ],
            [
                [],
                'pathInexistente',
                null,
                null,
            ],
            [
                ['data' => ['chave' => 'valor']],
                ['data.chave'],
                null,
                null,
            ],
            [
                ['data' => ['chave' => 'valor']],
                (new \stdClass()),
                'error',
                'error'
            ],
        ];
    }

    public function createFlashMessageProvider()
    {
        return [
            [
                'mensagem 01',
                'danger',
                [
                    'message' => 'mensagem 01',
                    'type' => 'danger'
                ]
            ],
            [
                'mensagem 02',
                'info',
                [
                    'message' => 'mensagem 02',
                    'type' => 'info'
                ]
            ],
            [
                'mensagem 02',
                'warning',
                [
                    'message' => 'mensagem 02',
                    'type' => 'warning'
                ]
            ],
            [
                '',
                '',
                [
                    'message' => '',
                    'type' => ''
                ]
            ]
        ];
    }

    public function formatFlashMessageProvider()
    {
        return [
            [
                ['message' => 'mensagem 01', 'type' => 'danger'],
                "<div class='alert alert-danger'>mensagem 01</div>"
            ],
            [
                ['message' => 'mensagem 02', 'type' => 'info'],
                "<div class='alert alert-info'>mensagem 02</div>"
            ],
            [
                ['message' => 'mensagem 02'],
                "<div class='alert alert-info'>mensagem 02</div>"
            ],
        ];
    }
}

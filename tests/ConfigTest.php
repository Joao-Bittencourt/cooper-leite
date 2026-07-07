<?php

namespace CooperLeite\Tests;

use PHPUnit\Framework\TestCase;
use CooperLeite\Config;

class ConfigTest extends TestCase
{
    private $oldEnv;

    protected function setUp(): void
    {
        include_once dirname(__DIR__) . '/src/core/basics.php';
        include_once dirname(__DIR__) . '/src/env.php';
        $this->oldEnv = $_ENV['ENVIRONMENT'] ?? null;
    }

    protected function tearDown(): void
    {
        if ($this->oldEnv === null) {
            unset($_ENV['ENVIRONMENT']);
        } else {
            $_ENV['ENVIRONMENT'] = $this->oldEnv;
        }
    }

    public function test_config_test_env()
    {
        $_ENV['ENVIRONMENT'] = 'TEST';
        $_ENV['TEST_DB_DRIVER'] = 'sqlite';
        $_ENV['TEST_DB_HOST'] = 'localhost';

        $config = new Config();
        $this->assertEquals('sqlite', $config->DB_DRIVER);
        $this->assertEquals('localhost', $config->DB_HOST);
    }

    public function test_config_prod_env()
    {
        $_ENV['ENVIRONMENT'] = 'PROD';
        $_ENV['DB_DRIVER'] = 'mysql';
        $_ENV['DB_HOST'] = '127.0.0.1';

        $config = new Config();
        $this->assertEquals('mysql', $config->DB_DRIVER);
        $this->assertEquals('127.0.0.1', $config->DB_HOST);
    }

    public function test_config_dev_env()
    {
        $_ENV['ENVIRONMENT'] = 'DESENV';
        $_ENV['DEV_DB_DRIVER'] = 'mysql';
        $_ENV['DEV_DB_HOST'] = 'dev-host';

        $config = new Config();
        $this->assertEquals('mysql', $config->DB_DRIVER);
        $this->assertEquals('dev-host', $config->DB_HOST);
    }

    public function test_config_docker_env()
    {
        $_ENV['ENVIRONMENT'] = 'DOCKER';
        $_ENV['DEV_DB_DRIVER'] = 'mysql';
        $_ENV['DEV_DB_HOST'] = 'docker-host';

        $config = new Config();
        $this->assertEquals('mysql', $config->DB_DRIVER);
        $this->assertEquals('docker-host', $config->DB_HOST);
    }

    public function test_config_invalid_env_throws()
    {
        $_ENV['ENVIRONMENT'] = 'INVALID';
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Environment config error');
        
        new Config();
    }
}

<?php

namespace CooperLeite\Tests\core;

use PHPUnit\Framework\TestCase;
use CooperLeite\Config;
use core\Database;

class DatabaseTest extends TestCase
{
    private $database;

    public function setUp(): void
    {
        $_ENV['ENVIRONMENT'] = 'TEST';

        $this->database = new Database();
        $this->database::$capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../database_test.sqlite',
            'prefix' => ''
        ]);
    }

    public function test_config_set_correctly()
    {

        $configuration = new Config();
        $configuration->DB_HOST = 'host';
        $configuration->DB_PORT = '1234';

        $configuration->DB_DATABASE = 'database_test';
        $configuration->DB_USER = 'user_test';
        $configuration->DB_PASS = 'pass_test';

        $this->database::inicializeConfig($configuration);
      
        $this->assertEquals($this->database::$config, $configuration);
    }
}
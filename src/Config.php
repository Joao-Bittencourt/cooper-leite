<?php

namespace CooperLeite;

class Config
{
    public const BASE_DIR = '';
    public $DB_DRIVER = '';
    public $DB_HOST = '';
    public $DB_PORT = '';
    public $DB_DATABASE = '';
    public $DB_USER = '';
    public $DB_PASS = '';
    public const ERROR_CONTROLLER = 'ErrorController';
    public const DEFAULT_ACTION = 'index';

    public function __construct()
    {
        if (file_exists(__DIR__ . '/env.php')) {
            include_once __DIR__ . '/env.php';
        }

        $environment = array_get($_ENV, 'ENVIRONMENT', false);

        switch ($environment) {
            case 'PROD':
                $this->DB_DRIVER = array_get($_ENV, 'DB_DRIVER');
                $this->DB_HOST = array_get($_ENV, 'DB_HOST');
                $this->DB_PORT = array_get($_ENV, 'DB_PORT');
                $this->DB_DATABASE = array_get($_ENV, 'DB_DATABASE');
                $this->DB_USER = array_get($_ENV, 'MYSQL_USER');
                $this->DB_PASS = array_get($_ENV, 'MYSQL_PASS');
                break;

            case 'TEST':
                $this->DB_DRIVER = array_get($_ENV, 'TEST_DB_DRIVER');
                $this->DB_HOST = array_get($_ENV, 'TEST_DB_HOST');
                $this->DB_PORT = array_get($_ENV, 'TEST_DB_PORT');
                $this->DB_DATABASE = array_get($_ENV, 'TEST_DB_DATABASE');
                $this->DB_USER = array_get($_ENV, 'TEST_MYSQL_USER');
                $this->DB_PASS = array_get($_ENV, 'TEST_MYSQL_PASS');
                break;

            case 'DOCKER':
            case 'DESENV':
                $this->DB_DRIVER = array_get($_ENV, 'DEV_DB_DRIVER');
                $this->DB_HOST = array_get($_ENV, 'DEV_DB_HOST');
                $this->DB_PORT = array_get($_ENV, 'DEV_DB_PORT');
                $this->DB_DATABASE = array_get($_ENV, 'DEV_DB_DATABASE');
                $this->DB_USER = array_get($_ENV, 'DEV_MYSQL_USER');
                $this->DB_PASS = array_get($_ENV, 'DEV_MYSQL_PASS');
                break;

            default:
                throw new \exception('Environment config error');
        }
    }
}

<?php

namespace CooperLeite;

class Config {

    const BASE_DIR = '';
    const DB_DRIVER = '';
    const DB_HOST = '';
    const DB_PORT = '';
    const DB_DATABASE = '';
    const DB_USER = '';
    const DB_PASS = '';
    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';

    public function __construct() {

        if (getenv('ENVIRONMENT') == 'TEST') {  
            $this->DB_DRIVER = getenv('TEST_DB_DRIVER');
            $this->DB_HOST = getenv('TEST_DB_HOST');
            $this->DB_PORT = getenv('TEST_DB_PORT');
            $this->DB_DATABASE = getenv('TEST_DB_DATABASE');
            $this->DB_USER = getenv('TEST_MYSQL_USER');
            $this->DB_PASS = getenv('TEST_MYSQL_PASS');
        }
        
        if (getenv('ENVIRONMENT') == 'PROD') {
            $this->DB_DRIVER = getenv('DB_DRIVER');
            $this->DB_HOST = getenv('DB_HOST');
            $this->DB_PORT = getenv('DB_PORT');
            $this->DB_DATABASE = getenv('DB_DATABASE');
            $this->DB_USER = getenv('MYSQL_USER');
            $this->DB_PASS = getenv('MYSQL_PASS');
        }
        
        if (in_array(getenv('ENVIRONMENT'), ['DESENV', 'DOCKER'])) {
                        
            $this->DB_DRIVER = getenv('DEV_DB_DRIVER') ? getenv('DEV_DB_DRIVER') : 'mysql';
            $this->DB_HOST = getenv('DEV_DB_HOST') ?: '127.0.0.1';
            $this->DB_PORT = getenv('DEV_DB_PORT') ?: '3308';
            $this->DB_DATABASE = getenv('DEV_DB_DATABASE') ?: 'cooper_leite';
            $this->DB_USER = getenv('DEV_MYSQL_USER') ? getenv('DEV_MYSQL_USER') : 'root';
            $this->DB_PASS = getenv('DEV_MYSQL_PASS') ? getenv('DEV_MYSQL_PASS') : '123.456';
        }
    }
}
